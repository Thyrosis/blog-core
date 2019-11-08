<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Libraries\Akismet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Setting;

class SubmitSpamController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Comment $comment)
    {
        if (!empty(Setting::get('comment.akismet.key'))) {
            $akismet = new Akismet($comment);

            if ($akismet->validateKey()) {
                $akismet->submitSpam();
            }

            $comment->update([
                'approved' => 0
            ]);

            Log::info("Comment passed through to Akismet for spam reporting, this is the result:", [$akismet->getResponse()]);

            return back()->with('success', 'The comment has been flagged as spam at Akismet');
        }
    }
}
