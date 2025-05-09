<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Book",
 *     description="Book model",
 *     @OA\Xml(
 *         name="Book"
 *     )
 * )
 */
class Book
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID of the book",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Title",
     *      description="Title of the book",
     *      example="The Great Gatsby"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *      title="Author",
     *      description="Author of the book",
     *      example="F. Scott Fitzgerald"
     * )
     *
     * @var string
     */
    private $author;

    /**
     * @OA\Property(
     *      title="Publication Year",
     *      description="Year the book was published",
     *      example=1925
     * )
     *
     * @var integer
     */
    private $publication_year;

    /**
     * @OA\Property(
     *      title="Created at",
     *      description="Creation date",
     *      example="2023-05-09T12:00:00.000000Z",
     *      format="datetime"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *      title="Updated at",
     *      description="Last updated",
     *      example="2023-05-09T12:00:00.000000Z",
     *      format="datetime"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;
}
