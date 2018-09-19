<?php namespace App\Http\Controllers\Inside;

use App\MyCore\Inside\Routing\MyController;
use View;
use App\Http\Models\Inside\Configs;
use App\Http\Requests\Inside\ConfigsRequest;

class ConfigsController extends MyController {

    private $_model = null;
    private $_params = array();
    public function __construct() {
        $options = array();
        $this->_params = \Request::all();
        $this->data['params'] = $this->_params;
        parent::__construct($options);

        $this->data['title'] = 'Configs';
        $this->data['controllerName'] = 'configs';
        $this->_model = new Configs();
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author Giau Le
     */
    public function getIndex() {
        return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
    }

    /**
     * Enter description here ...
     * @return \Illuminate\View\View
     * @author Giau Le
     */
    public function getShowAll() {
        $select = $this->_model->showAll($this->_params);
        $this->data['paginate'] = $select->paginate(PAGE_LIST_COUNT);

        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.show-all", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @return \Illuminate\View\View
     * @author Giau Le
     */
    public function getAdd() {
        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.add", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @param ConfigsRequest $request
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author Giau Le
     */
    public function postAdd(ConfigsRequest $request) {
        $request->merge(array('created_by' => $this->user->user_id));
        if ($this->_model->add($request)) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
        }
    }

    /**
     * Enter description here ...
     * @param unknown $id
     * @return \Illuminate\View\View
     * @author Giau Le
     */
    public function getEdit($id) {
        $object = $this->_model->findOrNew($id)->toArray();

        $modelTranslations = new \App\Http\Models\Inside\TranslationsTable($this->_model->tableTranslation, $this->_model->primaryKey);
        $dataTranslation = $modelTranslations->formatDataToDisplay($modelTranslations->getItemTranslations($id));
        if (count($dataTranslation)) {
            $object = array_merge($object, $dataTranslation);
        }

        $this->data['object'] = $object;
        return view("{$this->data['moduleName']}.{$this->data['controllerName']}.edit", $this->buildDataView($this->data));
    }

    /**
     * Enter description here ...
     * @param JobLevelsRequest $request
     * @param unknown $id
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author Giau Le
     */
    public function postEdit(ConfigsRequest $request, $id) {
        if ($this->_model->edit($request, $id)) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
        }
    }

    /**
     * Enter description here ...
     * @param unknown $id
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author Giau Le
     */
    public function getRemove($id) {
        if ($this->_model->remove($id)) {
            return redirect("/{$this->data['moduleName']}/{$this->data['controllerName']}/show-all");
        }
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author Giau Le
     */
    public function postRemove() {
        if (isset($this->_params['ids'])) {
            $this->_model->removeMulti($this->_params['ids']);
            die ('Completed');
        }
        die ('Failed');
    }
}
