<?php

namespace Main\Component\Blog;

class Like
{
    private UUID $uuid;
    private UUID $post_id;
    private UUID $user_id;

    public function __construct(UUID $uuid, UUID $post_id, UUID $user_id)
    {
        $this->uuid = $uuid;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
    }

    /**
     * @return UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @param UUID $uuid
     */
    public function setUuid(UUID $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return UUID
     */
    public function getPostId(): UUID
    {
        return $this->post_id;
    }

    /**
     * @param UUID $post_id
     */
    public function setPostId(UUID $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @return UUID
     */
    public function getUserId(): UUID
    {
        return $this->user_id;
    }

    /**
     * @param UUID $user_id
     */
    public function setUserId(UUID $user_id): void
    {
        $this->user_id = $user_id;
    }



}