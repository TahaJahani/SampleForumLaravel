<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Models\Question;
use App\Models\Reply;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function addQuestion(Request $request)
    {
        $question = Question::create([
            'title' => $request->title,
            'slug' => $request->slug,
        ]);
        return response()->json($question);
    }

    public function viewAllQuestions()
    {
        return Question::all();
    }

    public function viewQuestion(Request $request)
    {
        $replies = Reply::where('question_id', $request->question_id)->get();
        $replies = $this->nestReplies($replies, 0);
        ReplyResource::withoutWrapping();
        return ReplyResource::collection($replies);
    }

    public function addReply(Request $request)
    {
        $class = 'App\Models\\' . $request->class;
        $parent = $class::find($request->id);
        $reply = $parent->replies()->create([
            'slug' => $request->slug,
            'question_id' => ($class == Question::class) ? $parent->id : $parent->question_id,
        ]);
        return $reply;
    }

    private function nestReplies($replies, $i)
    {
        $toRemove = [];
        for ($j = 0; $j < sizeof($replies); $j++) {
            if ($replies[$i]->id == $replies[$j]->parent_id) {
                $replies[$i]->addReply($replies[$j]);
                array_push($toRemove, $j);
                $replies = $this->nestReplies($replies, $j);
            }
        }
        for ($j = 0 ; $j < sizeof($toRemove); $j++) {
            unset($replies[$toRemove[$j]]);
        }
        return $replies;
    }
}
