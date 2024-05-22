<?php
namespace App\Http\Objects;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
class ItemObject{
    private $id;
    private $name;
    private $description;
    private $image;
    private $price;
    private $created_at;
    private $updated_at;
    private $category_id;

    public function __construct($item)
    {
        $this->id = $item->id;
        $this->name = $item->name;
        $this->description = $item->description;
        $this->image = $item->image;
        $this->price = $item->price;
        $this->created_at = $item->created_at;
        $this->updated_at = $item->updated_at;
        $this->category_id = $item->category_id;
    }
    public function updateItem($name ,$description, $price , $category_id ,$image )
    {
        $item = Item::find($this->id);


        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category_id = $category_id;


        if ($image == NULL) {
            $this->image =$item->image;
        }else{
            Storage::delete($this->image);
            $this->image  = $image;
        }


        if ($item) {
            $item->update([
                'name' => $name,
                'description' => $description,
                'image' => $this->image,
                'price' => $price,
                'category_id' => $category_id
            ]);
        }else{
            return false;
        }
        return true;
    }
    public function getItem()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category_id' => $this->category_id
        ];
    }
    public function getId()
    {
        return $this->id;
    }

}
