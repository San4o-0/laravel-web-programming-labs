<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BlogPostAfterDeleteJob implements ShouldQueue
{
    use Queueable;

    /**
     * @var int
     */
    private $blogPostId;

    /**
     * Create a new job instance.
     *
     * @param int $blogPostId
     */
    public function __construct($blogPostId)
    {
        $this->blogPostId = $blogPostId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logs()->warning("Видалено запис в блозі [{$this->blogPostId}]");
    }
}
