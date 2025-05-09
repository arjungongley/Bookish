<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Book Request",
 *      description="Book request body data",
 *      type="object",
 *      required={"title", "author", "publication_year"}
 * )
 */
class BookRequest
{
    /**
     * @OA\Property(
     *      title="title",
     *      description="Title of the book",
     *      example="The Great Gatsby"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="author",
     *      description="Author of the book",
     *      example="F. Scott Fitzgerald"
     * )
     *
     * @var string
     */
    public $author;

    /**
     * @OA\Property(
     *      title="publication_year",
     *      description="Year the book was published",
     *      example=1925
     * )
     *
     * @var integer
     */
    public $publication_year;
}
