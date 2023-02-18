<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Applications",
 *     description="Applications model",
 *     @OA\Xml(
 *         name="Applications"
 *     )
 * )
 */
class Application extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="Application ID",
     *     description="Application ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var bigInteger
     */
    private $id;
    
    /**
     * @OA\Property(
     *     title="Customer ID",
     *     description="Customer ID",
     *     format="string",
     *     example=1
     * )
     *
     * @var string
     */
    private $customer_id;
    
    /**
     * @OA\Property(
     *     title="Customer first name",
     *     description="Customer first name",
     *     format="string",
     *     example="Vlad"
     * )
     *
     * @var string
     */
    private $customer_first_name;
    
    /**
     * @OA\Property(
     *     title="Customer lst name",
     *     description="Customer lst name",
     *     format="string",
     *     example="Ostryakov"
     * )
     *
     * @var string
     */
    private $customer_last_name;
    
    /**
     * @OA\Property(
     *     title="Customer patronymic",
     *     description="Customer patronymic",
     *     format="string",
     *     example="Pavlovich"
     * )
     *
     * @var string
     */
    private $customer_patronymic;
    
    /**
     * @OA\Property(
     *     title="Customer phone",
     *     description="Customer phone",
     *     format="string",
     *     example="+79128539823"
     * )
     *
     * @var string
     */
    private $customer_phone;
    
    /**
     * @OA\Property(
     *     title="Application city name",
     *     description="Application city name",
     *     format="string",
     *     example="Moskow"
     * )
     *
     * @var string
     */
    private $app_city;
    
    /**
     * @OA\Property(
     *     title="Application srteet name",
     *     description="Application srteet name",
     *     format="string",
     *     example="Polyani"
     * )
     *
     * @var string
     */
    private $app_street;
    
    /**
     * @OA\Property(
     *     title="Application house number",
     *     description="Application house number",
     *     format="string",
     *     example="9"
     * )
     *
     * @var string
     */
    private $app_house_number;
    
    /**
     * @OA\Property(
     *     title="Application house building number (corp)",
     *     description="Application house building number",
     *     format="string",
     *     example="12"
     * )
     *
     * @var string
     */
    private $app_house_building;
    
    /**
     * @OA\Property(
     *     title="Application house flat number",
     *     description="Application house flat number",
     *     format="string",
     *     example="912"
     * )
     *
     * @var string
     */
    private $app_flat_num;
    
    /**
     * @OA\Property(
     *     title="Application house floor number",
     *     description="Application house floor number",
     *     format="string",
     *     example="1"
     * )
     *
     * @var string
     */
    private $app_floor_num;
    
    /**
     * @OA\Property(
     *     title="Application house entrance number",
     *     description="Application house entrance number",
     *     format="string",
     *     example="90"
     * )
     *
     * @var string
     */
    private $app_house_entrance;
    
    /**
     * @OA\Property(
     *     title="Application created at",
     *     description="Application created at",
     *     format="datetime",
     *     example="2023-02-14 13:45:30"
     * )
     *
     * @var datetime
     */
    private $app_created_at;
    
    /**
     * @OA\Property(
     *     title="Application must been execute at",
     *     description="Application must been execute at",
     *     format="datetime",
     *     example="2023-02-14 13:45:30"
     * )
     *
     * @var datetime
     */
    private $app_to_execute_at;
    
    /**
     * @OA\Property(
     *     title="Master id",
     *     description="Master id",
     *     format="string",
     *     example="23"
     * )
     *
     * @var string
     */
    private $master_id;
    
    /**
     * @OA\Property(
     *     title="Application status",
     *     description="Application status. Application status must be: ....",
     *     format="string",
     *     example="In progress"
     * )
     *
     * @var string
     */
    private $app_status;
    
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="datetime",
     *     example="2023-02-14 13:45:30"
     * )
     *
     * @var datetime
     */
    private $created_at;
    
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="datetime",
     *     example="2023-02-14 13:45:30"
     * )
     *
     * @var datetime
     */
    private $updated_at;
}
