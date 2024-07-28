<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendContactRequest;
use App\Repositories\ContactUsRepository;
use App\Services\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected ContactUsRepository $contactUsRepo;
    protected ContactUsService $contactUsService;

    public function __construct(
        ContactUsRepository $contactUsRepo,
        ContactUsService $contactUsService
    )
    {
        $this->contactUsRepo = $contactUsRepo;
        $this->contactUsService = $contactUsService;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $contacts = $this->contactUsRepo->getAll($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $contacts
        ]);
    }

    public function detail(int $id): \Illuminate\Http\JsonResponse
    {
        $contact = $this->contactUsRepo->findById($id);

        if (is_null($contact)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Contact có #" . $id . " không tồn tại."
            ]);
        }
        $this->contactUsService->setStatus($contact);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $contact
        ]);
    }

    public function sendContact(SendContactRequest $request): \Illuminate\Http\JsonResponse
    {
        $requests = $request->all();
        $requests = array_merge($requests, ['ip' => $request->ip()]);
        $result = $this->contactUsService->sendContact($requests);

        if (!$result['success']) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => $result['message']
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => $result['message']
        ]);
    }

    public function changeStatus(int $id, Request $request): \Illuminate\Http\JsonResponse
    {
        $this->contactUsRepo->update($id, ['status' => $request->input('to_status')]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Change status success.'
        ]);
    }
}
