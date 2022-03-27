<?php

namespace VekaServer\TableForm;

use VekaServer\TableForm\Exception\ClientException;
use VekaServer\TableForm\Exception\ValidationException;
use VekaServer\Framework\Lang;
use VekaServer\Framework\Log;

class Contrainte
{

    public function __construct(){
    }

    public function ajax() :string
    {
        $retour = [];
        try{

            $methode = base64_decode($_POST['check'] ?? '');
            if (method_exists(static::class, $methode) === false) {
                throw new \Exception('tentative de contrainte sur une methode inexistante : '.static::class.'::'.$methode);
            }

            call_user_func(array(static::class, $methode));

            $retour['success'] = true;
            $retour['contrainte_failed'] = false;
            $retour['contrainte_msg'] = '';
        }catch (ValidationException $e){
            /** ici le traitement est toujours en success mais le champ doit passer en error */
            $retour['success'] = true;
            $retour['contrainte_failed'] = true;
            $retour['contrainte_msg'] = $e->getMessage();
        }catch (ClientException $e){
            $retour['success'] = false;
            $retour['error_msg'] = $e->getMessage();
        }catch (\Exception $e){
            Log::error($e);
            $retour['success'] = false;
            $retour['error_msg'] = Lang::get('erreur_generic');
        }

        return json_encode( $retour);
    }

}
