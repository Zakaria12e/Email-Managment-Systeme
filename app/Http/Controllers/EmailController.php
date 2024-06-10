<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\EmailConfiguration;
use App\Models\Destinataire;
use App\Models\Attachments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EmailController extends Controller
{
    private function checkEmailConfiguration($user_id)
    {
        $emailConfig = EmailConfiguration::where('user_id', $user_id)->first();
        if (!$emailConfig || !$emailConfig->mail_password) {
            return ['status' => false, 'message' => 'La configuration de l\'email est manquante ou incomplète'];
        }
        return ['status' => true, 'emailConfig' => $emailConfig];
    }


    public function index()
    {
        $userId = Auth::id();

        $emails = Email::where('user_id', $userId)->get();
        $emailCount = $emails->count();

        return response()->json([
            'emails' => $emails,
            'email_count' => $emailCount
        ]);
    }



    public function getExpediteurs()
    {
        $userId = Auth::id();

        $expediteurs = Email::where('user_id', $userId)
                            ->select('exped_nom', 'email_exped', 'exped_phone', 'exped_org')
                            ->get()
                            ->unique('email_exped');

        $count = $expediteurs->count();

        return response()->json([
            'Expediteurs' => $expediteurs,
            'count' => $count
        ]);
    }




    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'expediteur' => 'required',
            'expediteurOrg' => 'nullable',
            'expediteurEmail' => 'required',
            'expediteurPhone' => 'nullable',
            'dateValueExpedition' => 'required|date',
            'dateValueLimite' => 'nullable|date',
            'sujet' => 'required',
            'contenu' => 'required',
            'to' => 'nullable',
            'cc' => 'nullable',
            'cci' => 'nullable',
            'attachments.*' => 'required|file',
        ]);

        $user_id = Auth::id();

        // Check email configuration
        $configCheck = $this->checkEmailConfiguration($user_id);
        if (!$configCheck['status']) {
            return response()->json(['message' => $configCheck['message']], 400);
        }


        $dataToStore = [
            'exped_nom' => $validatedData['expediteur'],
            'email_exped' => $validatedData['expediteurEmail'],
            'date_exped' => $validatedData['dateValueExpedition'],
            'dead_line' => $validatedData['dateValueLimite'],
            'sujet' => $validatedData['sujet'],
            'contenu' => $validatedData['contenu'],
            'exped_org' => $validatedData['expediteurOrg'],
            'to' => $validatedData['to'],
            'cc' => $validatedData['cc'],
            'cci' => $validatedData['cci'],
            'exped_phone' => $validatedData['expediteurPhone'],
            'user_id' => $user_id,
            'nbr_env' => 1,
            'status' => 'envoyer',
        ];

        $email = Email::create($dataToStore);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $fileName = $attachment->getClientOriginalName();
                $filePath = Storage::putFile('attachments', $attachment);

                Attachments::create([
                    'user_id' => $user_id,
                    'email_id' => $email->id,
                    'nom_piece' => $fileName,
                    'type_piece' => $attachment->getClientMimeType(),
                    'chemin' => $filePath,
                ]);
            }
        }

        return response()->json(['message' => 'Email stored successfully'], 200);
    }

    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'to' => 'nullable|string',
            'cc' => 'nullable|string',
            'cci' => 'nullable|string',
            'sujet' => 'required|string',
            'contenu' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $user = Auth::user();

        // Check email configuration
        $configCheck = $this->checkEmailConfiguration($user->id);
        if (!$configCheck['status']) {
            return response()->json(['message' => $configCheck['message']], 400);
        }

        $emailConfig = $configCheck['emailConfig'];
        Config::set('mail.mailers.smtp.username', $emailConfig->mail_username);
        Config::set('mail.mailers.smtp.password', $emailConfig->mail_password);
        Config::set('mail.from.address', $emailConfig->mail_from_address);
        Config::set('mail.from.name', $user->name);


        $to = $request->input('to');
        $cc = $request->input('cc');
        $cci = $request->input('cci');
        $sujet = $validatedData['sujet'];
        $contenu = $validatedData['contenu'];

        $toEmails = $to ? explode(',', $to) : [];
        $ccEmails = $cc ? explode(',', $cc) : [];
        $cciEmails = $cci ? explode(',', $cci) : [];

        $attachments = $request->file('attachments');
        $attachmentPaths = [];

        if ($attachments) {
            foreach ($attachments as $index => $attachment) {
                $path = $attachment->store('attachments');
                $attachmentPaths[] = Storage::path($path);
            }
        }

        Mail::html($contenu, function ($message) use ($toEmails, $ccEmails, $cciEmails, $sujet, $attachmentPaths) {
            $message->subject($sujet);

            if (!empty($toEmails)) {
              $message->to($toEmails);
            }
            if (!empty($ccEmails)) {
                $message->cc($ccEmails);
            }
            if (!empty($cciEmails)) {
                $message->bcc($cciEmails);
            }
            foreach ($attachmentPaths as $attachmentPath) {
                $message->attach($attachmentPath);
            }
        });

        return response()->json(['message' => 'Email sent successfully'], 200);
    }

    public function show($id)
    {
        $email = Email::with('attachments')->findOrFail($id);
        return response()->json($email);
    }


}
