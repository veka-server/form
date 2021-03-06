<?php
namespace VekaServer\TableForm;

use VekaServer\TableForm\Exception\ClientException;
use VekaServer\TableForm\Model;
use VekaServer\Framework\Lang;
use VekaServer\Framework\Log;
use VekaServer\Framework\Controller;

class Tableau extends Controller
{

    private $columns = [];
    private $datas = [];
    private $actions = [];
    private $urlListe = null;
    private $urlExport = null;
    private $urlNewRow = null;
    private $cleaned_data = [];
    private $full_width = false;

    public function addColumn(array $array)
    {
        $this->columns[] = $array;
    }

    /** retourne le html du tableau sans les données */
    public function getHtmlWithoutData():string
    {
        return $this->getView('@TableForm/table/table.twig',[
            'columns' => $this->columns
            ,'urlListe' => $this->urlListe
            ,'urlExport' => $this->urlExport
            ,'urlNewRow' => $this->urlNewRow
            ,'full_width' => $this->full_width
        ]);
    }

    /** defini l'url ajax pour recuperer les données */
    public function setUrlListe(string $string)
    {
        $this->urlListe = $string;
    }

    /** nettoyer les donénes brut pour ne conserver que les données utiles */
    public function setData(array $datas)
    {
        $this->datas = $datas;
        $this->cleaned_data = [];
        foreach ($datas as $data){
            $current_data = [];
            foreach ($this->columns as $column){
                $current_data[$column['key']] = $data[$column['key']];
            }
            $this->cleaned_data[] = $current_data;
        }
    }

    public function getHtmlData()
    {
        return $this->getView('@TableForm/table/data.twig',[
            'cleaned_data' => $this->cleaned_data
            ,'data' => $this->datas
            ,'actions' => $this->actions
            ,'columns' => $this->columns
        ]);
    }

    public function setFonctionData(\Closure $callback, $addPagination = true)
    {
        $retour = [];
        try{
            $retour = $callback($retour);
            $retour['success'] = true;
        }catch (ClientException $e){
            $retour['success'] = false;
            $retour['error_msg'] = $e->getMessage();
        }catch (\Exception $e){
            Log::error($e);
            $retour['success'] = false;
            $retour['error_msg'] = Lang::get('erreur_generic');
        }

        $pagination = ($addPagination === true) ?  Model::getPaginationData() : [];

        return json_encode( array_merge($retour, $pagination));
    }

    /**
     * @param bool $full_width
     */
    public function setFullWidth(bool $full_width): void
    {
        $this->full_width = $full_width;
    }

    public function addAction(array $array)
    {
        $this->actions[] = $array;
    }

    /**
     * @return null
     */
    public function getUrlExport()
    {
        return $this->urlExport;
    }

    /**
     * @param string $urlExport
     */
    public function setUrlExport(string $urlExport): void
    {
        $this->urlExport = $urlExport;
    }

    /**
     * @return null
     */
    public function getUrlNewRow()
    {
        return $this->urlNewRow;
    }

    /**
     * @param string $urlNewRow
     */
    public function setUrlNewRow(string $urlNewRow): void
    {
        $this->urlNewRow = $urlNewRow;
    }

}
