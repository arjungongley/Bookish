<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID of the user",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the User",
     *      example="John Doe"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email address of the User",
     *      example="john@example.com"
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *      title="Email Verified At",
     *      description="Date and time when email was verified",
     *      example="2023-05-09T12:00:00.000000Z",
     *      format="datetime",
     *      nullable=true
     * )
     *
     * @var \DateTime
     */
    private $email_verified_at;

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
