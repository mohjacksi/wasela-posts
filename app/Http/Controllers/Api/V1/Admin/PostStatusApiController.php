<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostStatusRequest;
use App\Http\Requests\UpdatePostStatusRequest;
use App\Http\Resources\Admin\PostStatusResource;
use App\Models\PostStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('post_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PostStatusResource(PostStatus::all());
    }

    public function store(StorePostStatusRequest $request)
    {
        $postStatus = PostStatus::create($request->all());

        return (new PostStatusResource($postStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PostStatus $postStatus)
    {
        abort_if(Gate::denies('post_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PostStatusResource($postStatus);
    }

    public function update(UpdatePostStatusRequest $request, PostStatus $postStatus)
    {
        $postStatus->update($request->all());

        return (new PostStatusResource($postStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PostStatus $postStatus)
    {
        abort_if(Gate::denies('post_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
