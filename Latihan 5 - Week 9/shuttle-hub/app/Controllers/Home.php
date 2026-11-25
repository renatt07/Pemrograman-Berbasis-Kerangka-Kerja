<?php

namespace App\Controllers;

use App\Models\CourtModel;

class Home extends BaseController
{
    public function index()
    {
        $courtModel = new CourtModel();

        $floorFilter = $this->request->getGet('floor');
        $builder     = $courtModel->orderBy('id', 'ASC');

        if (! empty($floorFilter)) {
            $builder->where('floor_type', $floorFilter);
        }

        $floors = $courtModel->select('floor_type')->distinct()->findAll();

        return view('home', [
            'title'       => 'Beranda',
            'courts'      => $builder->findAll(),
            'floors'      => array_column($floors, 'floor_type'),
            'floorFilter' => $floorFilter,
        ]);
    }
}