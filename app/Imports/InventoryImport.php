<?php

namespace App\Imports;

use App\Helpers\Numbering;
use App\Helpers\Utility;
use App\model\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class InventoryImport implements 
ToModel,
WithHeadingRow,
WithBatchInserts,
WithChunkReading,
SkipsOnError,
WithValidation,
SkipsOnFailure
{

    use Importable, SkipsErrors;

    protected $data;

    public function __construct($data){
        $this->data = $data;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $photo = 'default_image.png';
        $currId = session('currency')['id'];
        $dbDATA = [
            'item_no' => Numbering::inventoryImport(++$this->data->dataId),
            'item_name' => $row['item_name'],
            'as_of_date' => date('Y-m-d'),
            'sales_desc' => $row['sales_description'],
            'purchase_desc' => $row['purchase_description'],
            'unit_measure' => $this->data->unitMeasure,
            'qty' => $row['quantity'],
            'category_id' => $this->data->category,
            'inventory_type' => $this->data->inventoryType,
            'whse_status' => $this->data->storageType,
            're_order_level' => $row['re_order_level'],
            'photo' => $photo,
            'unit_cost' => $row['unit_cost'],
            'expense_account' => $this->data->expense,
            'unit_price' => $row['unit_price'],
            'curr_id' => $currId,
            'income_account' => $this->data->income,
            'inventory_account' => $this->data->inventory,
            'active_status' => Utility::STATUS_ACTIVE,
            'created_by' => Auth::user()->id,
            'status' => Utility::STATUS_ACTIVE
        ];
        return new Inventory($dbDATA);
        
    }

    public function rules(): array
    {
        return [
             // Above is alias for as it always validates in batches
             '*.item_name' => ['required', 'string'],
             '*.sales_description' => ['required', 'string'],
             '*.purchase_description' => ['required', 'string'],
             '*.quantity' => ['required', 'numeric'],
             '*.re_order_level' => ['required'],
             '*.unit_cost' => ['required'],
             '*.unit_price' => ['required'],
        ];
    }

    public function onError(Throwable $e)
    {
        // Handle the exception how you'd like.
    }

    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    public function batchSize(): int
    {
        return 20;
    }

    public function chunkSize(): int
    {
        return 50;
    }

}
