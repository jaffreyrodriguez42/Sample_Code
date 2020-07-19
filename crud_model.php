namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //eloquent relationship // one to many // categories to assets
    public function assets()
    {
        return $this->hasMany('\App\Asset');
    }

    //eloquent relationship // one to many // categories to transactions
    public function transactions()
    {
        return $this->hasMany('\App\Transactions');
    }
}
