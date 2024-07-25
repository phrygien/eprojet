<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['numero_transaction', 'date_transac', 'num_transac_partenaire', 'partenaire_id', 'abonnement_id', 'user_id',	'montant',	'status', 'commentaire', 'mpgw_token', 'state'];

    public static function genererNumeroTransaction(){
        $found = 0;
        while ($found == 0) {
            $numero = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
            try {
                $count = Transaction::where('numero_transaction', $numero)->count();
                if ($count == 0) {
                    $code_generer = $numero;
                    $found = 1;
                    break;
                }
            } catch (\PDOException $e) {
                throw $e;
                die;
            }
        }
        return $code_generer;
      }
}
