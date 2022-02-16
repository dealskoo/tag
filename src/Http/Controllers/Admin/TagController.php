<?php

namespace Dealskoo\Tag\Http\Controllers\Admin;

use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Admin\Rules\Slug;
use Dealskoo\Country\Models\Country;
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
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'name', 'slug', 'country_id'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Tag::query();
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $tags = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('tags.show');
        $can_edit = $request->user()->canDo('tags.edit');
        $can_destroy = $request->user()->canDo('tags.destroy');
        foreach ($tags as $tag) {
            $row = [];
            $row[] = $tag->id;
            $row[] = $tag->name;
            $row[] = $tag->slug;
            $row[] = $tag->country->name;

            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.tags.show', $tag) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.tags.edit', $tag) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $destroy_link = '';
            if ($can_destroy) {
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="tags_table" data-url="' . route('admin.tags.destroy', $tag) . '"> <i class="mdi mdi-delete"></i></a>';
            }
            $row[] = $view_link . $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
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
        $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', new Slug('tags', 'slug')],
            'country_id' => ['required', 'exists:countries,id']
        ]);
        $tag = new Tag($request->only([
            'name',
            'slug',
            'country_id'
        ]));
        $tag->save();
        return back()->with('success', __('admin::admin.added_success'));
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
        $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', new Slug('tags', 'slug', $id, 'id')],
            'country_id' => ['required', 'exists:countries,id']
        ]);

        $tag = Tag::query()->findOrFail($id);
        $tag->fill($request->only([
            'name',
            'slug',
            'country_id'
        ]));
        $tag->save();
        return back()->with('success', __('admin::admin.update_success'));
    }

    public function destroy(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('tags.destroy'), 403);
        return ['status' => Tag::destroy($id)];
    }
}
