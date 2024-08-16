<?php

namespace App\Http\Controllers;

use App\Models\EventImage;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class EventImageController extends Controller
{
    public function store(Request $request, $eventId)
    {
        try {
            $validated = $request->validate([
                'image_url' => 'required|url',
            ]);

            $event = Event::findOrFail($eventId);
            $image = $event->images()->create($validated);

            return response()->json(['image' => $image, 'message' => trans('event_images.added_successfully')], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => trans('validation_failed'), 'errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => trans('events.not_found'), 'error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('event_images.failed_addition'), 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $image = EventImage::findOrFail($id);
            $image->delete();
            return response()->json(['message' => trans('event_images.deleted_successfully')], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => trans('event_images.not_found'), 'error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('event_images.failed_deletion'), 'error' => $e->getMessage()], 500);
        }
    }
}
