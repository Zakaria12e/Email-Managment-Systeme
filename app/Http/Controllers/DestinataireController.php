<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Destinataire;
use App\Models\Role;

class DestinataireController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $destinataires = Destinataire::where('user_id', $userId)
            ->with(['department', 'roles'])
            ->get();

        $count = $destinataires->count();

        $formattedDestinataires = $destinataires->map(function ($destinataire) {
            return [
                'id' => $destinataire->id,
                'nom_prenom' => $destinataire->nom_dest . ' ' . $destinataire->prenom_dest,
                'telephone' => $destinataire->telephone_dest,
                'emails' => $destinataire->first_email . ', ' . $destinataire->second_email,
                'email1' => $destinataire->first_email,
                'email2' => $destinataire->second_email,
                'nom' => $destinataire->nom_dest,
                'prenom' => $destinataire->prenom_dest,
                'department' => $destinataire->department->dept_name,
                'rolesiIds' => $destinataire->roles->pluck('id'),
                'rolesNames' => $destinataire->roles->pluck('name')->implode(", "),

            ];
        });

        return response()->json($formattedDestinataires);
    }

    public function destinatairesCount()
{

    $userId = Auth::id();

    $destinataires = Destinataire::where('user_id', $userId)
        ->with(['department', 'roles'])
        ->get();

    $count = $destinataires->count();

    return response()->json([

        'count' => $count,
    ]);
}





    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'structurId' => 'nullable',
            'phone' => 'required',
            'departmentId' => 'required',
            'email1' => 'required|email',
            'email2' => 'nullable|email',
            'roles' => 'required|array',
        ]);


        $destinataire = Destinataire::create([
            'nom_dest' => $validatedData['last_name'],
            'prenom_dest' => $validatedData['first_name'],
            'telephone_dest' => $validatedData['phone'],
            'first_email' => $validatedData['email1'],
            'second_email' => $validatedData['email2'],
            'department_id' => $validatedData['departmentId'],
        ]);

        $destinataire->roles()->attach($validatedData['roles']);

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }



    public function checkUniqueFields(Request $request)
    {
        $email1Unique = Destinataire::where('first_email', $request->input('email1'))->doesntExist();


        $email2Unique = true;
        if ($request->filled('email2')) {
            $email2Unique = Destinataire::where('second_email', $request->input('email2'))->doesntExist();
        }

        $phoneUnique = Destinataire::where('telephone_dest', $request->input('phone'))->doesntExist();

        return response()->json([
            'email1Unique' => $email1Unique,
            'email2Unique' => $email2Unique,
            'phoneUnique' => $phoneUnique,
        ]);
    }

    public function getEmail($id)
    {
        $destinataire = Destinataire::findOrFail($id);
    return response()->json([
        'first_email' => $destinataire->first_email,
        'second_email' => $destinataire->second_email
    ]);
    }


    public function getEmailsByRole(Request $request)
{
    $selectedRoles = $request->input('selectedRoles');


    $destinataires = Destinataire::whereHas('roles', function ($query) use ($selectedRoles) {
        $query->whereIn('id', $selectedRoles);
    })->get();


    $emails = $destinataires->pluck('first_email')->unique();

    return response()->json([
        'emails' => $emails,
    ]);
}

}
