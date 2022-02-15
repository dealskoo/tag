<?php

namespace Dealskoo\Tag\Http\Controllers\Admin;

use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Tag\Models\Tag;
use Illuminate\Http\Request;

class TagController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('tags.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('tag::admin.tag.index');
        }
    }

    private function table(Request $request)
    {

    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('tags.show'), 403);
        $countries = Country::all();
        $tag = Tag::query()->findOrFail($id);
        return view('tag::admin.tag.show', ['countries' => $countries, 'tag' => $tag]);
    }

    public function create(Request $request)
    {
        abort_if(!$request->user()->canDo('tags.create'), 403);
        $countries = Country::all();
        return view('tag::admin.tag.create', ['countries' => $countries]);
    }

    public function store(Request $request)
    {
        abort_if(!$request->user()->canDo('tags.create'), 403);

    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('tags.edit'), 403);
        $countries = Country::all();
        $tag = Tag::query()->findOrFail($id);
        return view('tag::admin.tag.edit', ['countries' => $countries, 'tag' => $tag]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('tags.edit'), 403);

    }

    public function destroy(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('tags.destroy'), 403);
        return ['status' => Tag::destroy($id)];
    }
}
