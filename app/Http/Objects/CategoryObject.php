<?php
namespace App\Http\Objects;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
class CategoryObject{
    private $id;
    private $name;
    private $description;
    private $image;
    private $created_at;
    private $updated_at;

    public function __construct($category)
    {
        $this->id = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->image = $category->image;
        $this->created_at = $category->created_at;
        $this->updated_at = $category->updated_at;
    }
    public function updateCategory($name ,$description,$image )
    {
        $category = Category::find($this->id);


        $this->name = $name;
        $this->description = $description;

        if ($image == NULL) {
            $this->image =$category->image;
        }else{
            Storage::delete($this->image);
            $this->image  = $image;
        }


        if ($category) {
            $category->update([
                'name' => $name,
                'description' => $description,
                'image' => $this->image,
            ]);
        }else{
            return false;
        }
        return true;
    }
    public function getCategory()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function getId()
    {
        return $this->id;
    }

}
