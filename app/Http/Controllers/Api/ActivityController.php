<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ActivitySearchRequest;
use App\Http\Requests\ActivityStoreRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Resources\Api\ActivityIndexResource;
use App\Http\Resources\Api\ActivityShowResource;
use App\Http\Resources\Api\ActivityStoreResource;
use App\Http\Resources\Api\ActivityUpdateResource;
use App\Interfaces\Api\ActivityControllerInterface;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends BaseController implements ActivityControllerInterface
{
    public function index()
    {
        $activities = Activity::paginate(10);

        return $this->sendResponse(new ActivityIndexResource($activities), 'Lista  de atividades');
    }

    public function store(ActivityStoreRequest $request)
    {

        if ($this->overlappingActivities($request->user_id, $request->start_date, $request->end_date)) {
            return $this->sendError('Já existe uma atividade cadastrada para este usuário nesta data ou período.', [], 422);
        }

        $new = Activity::create($request->validated());

        return $this->sendResponse(new ActivityStoreResource($new), 'Atividades cadastrado', 201);
    }

    public function search(ActivitySearchRequest $request)
    {
        if (empty($request->all())) {
            return $this->sendError('Nenhum campo foi enviado na requisição', [], 404);
        }
        $query = Activity::query();

        match (true) {
            $request->has('id') => $query->where('id', $request->id),
            $request->has('user_id') => $query->where('user_id', $request->user_id),
            $request->has('title') => $query->where('title', 'like', '%'.$request->title.'%'),
            $request->has('type') => $query->where('type', 'like', '%'.$request->type.'%'),
            $request->has('description') => $query->where('description', 'like', '%'.$request->description.'%'),
            $request->has('start_date') => $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                ->orWhereBetween('end_date', [$request->start_date, $request->end_date]),
            $request->has('completion_date') => $query->where('completion_date', $request->completion_date),
            default => null,
        };

        return $this->sendResponse(new ActivityShowResource($query->paginate(10)), 'Atividade cadastrado', 200);
    }

    public function update(ActivityUpdateRequest $request, Activity $activity)
    {
        if ($request->all() == null) {
            return $this->sendError('Nenhum campo foi enviado na requisição', [], 422);
        }

        if (($request->has('start_date') || $request->has('end_date')) && $this->overlappingActivities($activity->user_id, $activity->start_date, $activity->end_date, $activity->id)) {
            return $this->sendError('Já existe uma atividade cadastrada para este usuário nesta data ou período.', [], 422);
        }

        $activity->update($request->validated());

        return $this->sendResponse(new ActivityUpdateResource($activity), 'Atividade atualizado', 200);
    }

    public function destroy($id)
    {
        $activity = Activity::find($id);

        if (! $activity) {
            return $this->sendError('Atividade não encontrado', [], 404);
        }

        $activity->delete();

        return $this->sendResponse([], 'Atividade deletada', 200);
    }

    private function overlappingActivities($user_id, $start_date, $end_date, $id = null)
    {
        return Activity::where('user_id', $user_id)
            ->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date]);
            })
            ->where('id', '!=', $id)
            ->exists();
    }
}
