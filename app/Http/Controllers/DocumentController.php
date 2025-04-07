<?php

namespace App\Http\Controllers;
use App\Document;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    //
    protected $chatHistory = [];
    public function chat()
    {
        return view('chat', [
            'chatMessages' => $this->chatHistory
        ]);
    }
    public function create()
    {
        return view('post');
    }
    public function store(Request $request)
{
    
    $validator = Validator::make($request->all(), [
        'group' => 'required|string',
        'title' => 'required|string',
        'content' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422); // 422 = Unprocessable Entity
    }

    // Store document in MySQL
    $document = Document::create([
        'title' => $request->input('title'),
        'group' => $request->input('group'),
        'content' => $request->input('content'),
    ]);

    return response()->json([
        'success' => true,
        'data' => $document
    ], 201); // 201 = Created
}
    public function retrieve(Request $request)
    {
        $query = $request->input('query');
        $validator = Validator::make($request->all(), [
            'query' => 'required|string',
            'group' => 'group|string',
        ]);
    
        return Document::where('group',$request->group)->whereRaw("MATCH(content) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query])->get();
    }
    public function generateResponse(Request $request)
    {
        // dd(env('OPENAI_API_KEY'));
        $query = $request->input('query');

        // Retrieve relevant documents
        $documents = $this->retrieve($request);

        $context = "";
        foreach ($documents as $doc) {
            $context .= $doc->content . "\n\n";
        }

        // Generate response using GPT-4
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'Use the following documents as context to answer the query: ' . $context],
                    ['role' => 'user', 'content' => $query],
                ],
            ],
        ]);

        return response()->json(json_decode($response->getBody(), true)['choices'][0]['message']['content']);
    }

    private function retrieveDocuments($query)
    {
        return Document::whereRaw("MATCH(content) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query])->get();
    }
}
