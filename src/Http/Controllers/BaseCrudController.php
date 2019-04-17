<?php

namespace TheRezor\LaraCrud\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use TheRezor\LaraCrud\Forms\FilterForm;
use TheRezor\LaraCrud\Http\Controllers\Traits\Routable;
use TheRezor\LaraCrud\Http\Crud\BaseCrud;
use FormBuilder;

abstract class BaseCrudController extends Controller
{
    use Routable;

    /**
     * @var BaseCrud
     */
    protected $crud;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->crud->getRepository()->pushCriteria($this->crud->getOrderCriteria());

        $emptyEntity = $this->crud->getRepository()->newModel();

        $filterForm = $this->crud->getFilterFormClass();

        if ($filterForm) {
            /** @var FilterForm $filterForm */
            $filterForm = FormBuilder::create($filterForm, [
                'model' => $emptyEntity,
            ]);

            $this->crud->getRepository()->pushCriteria($filterForm->getFilterCriteria());
        }

        $entities = $this->crud->getRepository()->paginate($this->crud->perPage);

        $fields = $this->crud->getListFields();

        return view($this->crud->getViewByMethod('index'))
            ->with('crud', $this->crud)
            ->with('fields', $fields)
            ->with('emptyEntity', $emptyEntity)
            ->with('filterForm', $filterForm)
            ->with('entities', $entities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $entity = $this->crud->getRepository()->newModel();

        $form = $this->crud->getCreateFormClass();

        if ($form) {
            $form = FormBuilder::create($form, [
                'method' => 'post',
                'model'  => $entity,
                'route'  => $this->crud->getRouteByMethod('store'),
            ]);
        }

        return view($this->crud->getViewByMethod('create'))
            ->with('entity', $entity)
            ->with('form', $form)
            ->with('crud', $this->crud);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $entity = $this->crud->getRepository()->newModel();

        $form = $this->crud->getCreateFormClass();

        if ($form) {
            $form = FormBuilder::create($form, [
                'method' => 'post',
                'model'  => $entity,
                'route'  => $this->crud->getRouteByMethod('store'),
            ]);

            $form->redirectIfNotValid();

            $fieldValues = $form->getFieldValues(true);

            $this->crud->beforeStore($entity, $fieldValues);

            $entity = $this->crud->getRepository()->create($fieldValues);

            $this->crud->afterStore($entity, $fieldValues);
        }

        return redirect()->route($this->crud->getRouteByMethod('index'))
            ->with('flash_success', trans('laracrud::crud.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $entity = $this->crud->getRepository()->findOrFail($id);

        $fields = $this->crud->getShowFields();

        return view($this->crud->getViewByMethod('show'))
            ->with('entity', $entity)
            ->with('fields', $fields)
            ->with('crud', $this->crud);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $entity = $this->crud->getRepository()->findOrFail($id);

        $form = $this->crud->getEditFormClass();

        if ($form) {
            $form = FormBuilder::create($form, [
                'method' => 'patch',
                'model'  => $entity,
                'route'  => [$this->crud->getRouteByMethod('update'), $id],
            ]);
        }

        return view($this->crud->getViewByMethod('edit'))
            ->with('entity', $entity)
            ->with('form', $form)
            ->with('crud', $this->crud);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  FormBuilder $formBuilder
     * @return Response
     */
    public function update($id)
    {
        $entity = $this->crud->getRepository()->findOrFail($id);

        $form = $this->crud->getEditFormClass();

        if ($form) {
            $form = FormBuilder::create($form, [
                'method' => 'patch',
                'model'  => $entity,
                'route'  => $this->crud->getRouteByMethod('update'),
            ]);

            $form->redirectIfNotValid();

            $fieldValues = $form->getFieldValues(true);

            $this->crud->beforeUpdate($entity, $fieldValues);

            $entity = $this->crud->getRepository()->update($id, $fieldValues);

            $this->crud->afterUpdate($entity, $fieldValues);
        }

        return redirect()->route($this->crud->getRouteByMethod('index'))
            ->with('flash_success', trans('laracrud::crud.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $entity = $this->crud->getRepository()->findOrFail($id);

        $this->crud->beforeDestroy($entity);

        $this->crud->getRepository()->delete($id);

        $this->crud->afterDestroy($entity);

        return redirect()->route($this->crud->getRouteByMethod('index'))
            ->with('flash_success', trans('laracrud::crud.deleted'));
    }
}
