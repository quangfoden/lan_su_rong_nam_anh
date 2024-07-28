<?php
namespace App\Services;


use App\Enums\ContactUsStatus;
use App\Enums\General;
use App\Models\ContactUs;
use App\Repositories\ContactUsRepository;

class ContactUsService {
    protected ContactUsRepository $contactUsRepo;

    public function __construct(ContactUsRepository $contactUsRepo)
    {
        $this->contactUsRepo = $contactUsRepo;
    }

    public function sendContact(array $requests): array
    {
        $countSpam = $this->contactUsRepo->countSpam($requests['ip']);
        if ($countSpam >= General::MAX_CONTACT_SPAM) {
            return [
                'success' => false,
                'message' => 'The system detects you are spam. Please contact admin for support.'
            ];
        }
        $this->contactUsRepo->create($requests);

        return [
            'success' => true,
            'message' => 'Send mail success.'
        ];
    }

    public function setStatus(ContactUs $contact): void
    {
        if ($contact->status === ContactUsStatus::INITIAL) {
            $this->contactUsRepo->update($contact->id, ['status' => ContactUsStatus::SEEN]);
        }
    }
}
