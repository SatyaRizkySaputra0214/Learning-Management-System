<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingCount = Registration::where('status', 'pending')->count();
        $totalStudents = User::where('role', 'murid')->count();
        $totalGurus = User::where('role', 'guru')->count();
        $totalClasses = ClassModel::count();

        // New data for improved dashboard
        $recentRegistrations = Registration::orderBy('created_at', 'desc')->take(5)->get();
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        
        // Distribution of students by course
        $courseStats = [
            'English' => Registration::where('kursus_pilihan', 'eng')->count(),
            'Korean' => Registration::where('kursus_pilihan', 'kor')->count(),
            'Thai' => Registration::where('kursus_pilihan', 'th')->count(),
        ];

        // Active classes summary
        $activeClasses = ClassModel::with(['course', 'guru'])
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendingCount', 
            'totalStudents', 
            'totalGurus', 
            'totalClasses',
            'recentRegistrations',
            'recentUsers',
            'courseStats',
            'activeClasses'
        ));
    }

    public function registrations(Request $request)
    {
        $query = Registration::with('verifier');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Course filter
        if ($request->filled('kursus')) {
            $query->where('kursus_pilihan', $request->kursus);
        }
        
        $registrations = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        return view('admin.registrations.index', compact('registrations'));
    }

    public function showRegistration(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    public function verifyRegistration(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:verified,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $registration->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'verified_by' => auth()->id(),
        ]);

        return redirect()->route('admin.registrations.index')->with('success', 'Registrasi berhasil diverifikasi.');
    }

    public function createUserFromRegistration(Registration $registration)
    {
        if ($registration->status !== 'verified') {
            return back()->with('error', 'Registrasi harus diverifikasi terlebih dahulu.');
        }

        if ($registration->user_id) {
            return back()->with('error', 'User sudah dibuat untuk registrasi ini.');
        }

        $courses = Course::all();
        return view('admin.registrations.create-user', compact('registration', 'courses'));
    }

    public function storeUserFromRegistration(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,guru,murid',
            'id_class' => 'nullable|exists:classes,id',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'nama_lengkap' => $registration->nama,
            'email' => $registration->email,
            'tingkat_bahasa' => $registration->tingkat_bahasa,
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        $registration->update(['user_id' => $user->id]);

        if ($validated['role'] === 'murid' && $validated['id_class']) {
            $user->enrolledClasses()->attach($validated['id_class']);
        }

        return redirect()->route('admin.registrations.index')->with('success', 'User berhasil dibuat.');
    }

    public function deleteRegistration(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('admin.registrations.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }

    public function users(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('role')->orderBy('nama_lengkap')->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function gurus(Request $request)
    {
        $query = User::where('role', 'guru');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('nama_lengkap')->paginate(10)->withQueryString();
        $title = 'Manajemen Guru';
        $subtitle = 'Kelola akun pengajar / guru';
        $role = 'guru';
        
        return view('admin.users.index', compact('users', 'title', 'subtitle', 'role'));
    }

    public function murids(Request $request)
    {
        $query = User::where('role', 'murid')->with('enrolledClasses.course');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Course filter
        if ($request->filled('kursus')) {
            $query->whereHas('enrolledClasses', function($q) use ($request) {
                $q->where('id_course', $request->kursus);
            });
        }

        $users = $query->orderBy('nama_lengkap')->paginate(10)->withQueryString();
        $courses = Course::all();
        $title = 'Manajemen Murid';
        $subtitle = 'Kelola akun siswa / murid';
        $role = 'murid';
        
        return view('admin.users.index', compact('users', 'title', 'subtitle', 'role', 'courses'));
    }

    public function admins(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('nama_lengkap')->paginate(10)->withQueryString();
        $title = 'Manajemen Admin';
        $subtitle = 'Kelola akun administrator';
        $role = 'admin';
        
        return view('admin.users.index', compact('users', 'title', 'subtitle', 'role'));
    }

    public function createUser(Request $request)
    {
        $selectedRole = $request->query('role');
        $classes = [];
        
        // Selalu ambil kelas jika kemungkinan role adalah murid
        // atau jika admin ingin memilih kelas saat membuat guru (opsional, tapi request hanya minta murid)
        $classes = ClassModel::with(['course', 'guru'])->where('status', 'aktif')->get();
        
        return view('admin.users.create', compact('selectedRole', 'classes'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,guru,murid',
            'tingkat_bahasa' => 'nullable|string|max:50',
            'password' => ['required', 'confirmed', 'min:8'],
            'id_class' => 'nullable|exists:classes,id',
        ]);

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'tingkat_bahasa' => $validated['tingkat_bahasa'],
            'password' => Hash::make($validated['password']),
        ]);

        // Tambahkan ke kelas jika role adalah murid dan id_class dipilih
        if ($validated['role'] === 'murid' && !empty($validated['id_class'])) {
            $user->enrolledClasses()->attach($validated['id_class']);
        }

        $redirectRoute = 'admin.users.index';
        if ($validated['role'] === 'guru') $redirectRoute = 'admin.users.gurus';
        elseif ($validated['role'] === 'murid') $redirectRoute = 'admin.users.murids';
        elseif ($validated['role'] === 'admin') $redirectRoute = 'admin.users.admins';

        return redirect()->route($redirectRoute)->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        $registration = null;
        $classes = [];
        
        if ($user->role === 'murid') {
            $registration = Registration::where('user_id', $user->id)->first();
            $classes = ClassModel::with(['course', 'guru'])->where('status', 'aktif')->get();
        }
        
        return view('admin.users.edit', compact('user', 'registration', 'classes'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,guru,murid',
            'tingkat_bahasa' => 'nullable|string|max:50',
            'password' => 'nullable|min:8|confirmed',
            'id_class' => 'nullable|exists:classes,id',
        ]);

        $user->nama_lengkap = $validated['nama_lengkap'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->tingkat_bahasa = $validated['tingkat_bahasa'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Update class enrollment for murid
        if ($user->role === 'murid' && isset($validated['id_class'])) {
            // If id_class is provided, sync it (this will replace current enrollments if any)
            // Or should we just add it? The request says "mengedit(merubah) bahasa", 
            // usually implying a primary class.
            $user->enrolledClasses()->sync($validated['id_class'] ? [$validated['id_class']] : []);
        }

        $redirectRoute = 'admin.users.index';
        if ($user->role === 'guru') $redirectRoute = 'admin.users.gurus';
        elseif ($user->role === 'murid') $redirectRoute = 'admin.users.murids';
        elseif ($user->role === 'admin') $redirectRoute = 'admin.users.admins';

        return redirect()->route($redirectRoute)->with('success', 'User berhasil diupdate.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus user yang sedang login.');
        }

        $role = $user->role;
        $user->delete();

        $redirectRoute = 'admin.users.index';
        if ($role === 'guru') $redirectRoute = 'admin.users.gurus';
        elseif ($role === 'murid') $redirectRoute = 'admin.users.murids';
        elseif ($role === 'admin') $redirectRoute = 'admin.users.admins';

        return redirect()->route($redirectRoute)->with('success', 'User berhasil dihapus.');
    }

    public function classes(Request $request)
    {
    $query = ClassModel::with(['course', 'guru', 'students'])->where('is_archived', false);
 
        // Filter berdasarkan search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kelas', 'like', "%{$search}%")
                  ->orWhere('periode', 'like', "%{$search}%")
                  ->orWhereHas('course', function($q2) use ($search) {
                      $q2->where('nama_bahasa', 'like', "%{$search}%");
                  })
                  ->orWhereHas('guru', function($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan kursus
        if ($request->filled('kursus')) {
            $query->whereHas('course', function($q) use ($request) {
                $q->where('kode', $request->kursus);
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $classes = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        // Get all courses for filter dropdown
        $courses = \App\Models\Course::all();
        
        return view('admin.classes.index', compact('classes', 'courses'));
    }

    public function showClass(ClassModel $class)
    {
        $class->load(['course', 'guru', 'students']);

        // Ambil murid yang sudah enroll di kelas ini
        $enrolledStudentIds = $class->students->pluck('id')->toArray();

        // Ambil murid yang belum enroll di kelas ini, tapi hanya yang mendaftar kursus yang sama
        $availableStudents = User::where('role', 'murid')
            ->whereDoesntHave('enrolledClasses', function($q) use ($class) {
                $q->where('class_students.id_class', $class->id);
            })
            ->whereHas('registrations', function($q) use ($class) {
                // Filter berdasarkan kursus yang sama dengan kelas
                $q->where('kursus_pilihan', $class->course->kode);
            })
            ->orderBy('nama_lengkap')
            ->get();

        // Hitung total murid per kursus untuk statistik
        $studentsByCourse = User::where('role', 'murid')
            ->whereHas('registrations', function($q) {
                $q->whereIn('kursus_pilihan', ['eng', 'kor', 'th']);
            })
            ->get()
            ->groupBy(function($user) {
                $registration = $user->registrations()->latest()->first();
                return $registration ? $registration->kursus_pilihan : 'unknown';
            });

        return view('admin.classes.show', compact('class', 'availableStudents', 'enrolledStudentIds', 'studentsByCourse'));
    }

    public function createClass()
    {
        $courses = Course::all();
        $gurus = User::where('role', 'guru')->get();
        return view('admin.classes.create', compact('courses', 'gurus'));
    }

    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'id_course' => 'required|exists:courses,id',
            'id_guru' => 'required|exists:users,id',
            'nama_kelas' => 'required|string|max:255',
            'periode' => 'required|string|max:255',
            'status' => 'required|in:aktif,selesai',
            'jumlah_hari' => 'required|integer|min:1|max:100',
        ]);

        ClassModel::create($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function editClass(ClassModel $class)
    {
        $courses = Course::all();
        $gurus = User::where('role', 'guru')->get();
        return view('admin.classes.edit', compact('class', 'courses', 'gurus'));
    }

    public function updateClass(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            'id_course' => 'required|exists:courses,id',
            'id_guru' => 'required|exists:users,id',
            'nama_kelas' => 'required|string|max:255',
            'periode' => 'required|string|max:255',
            'status' => 'required|in:aktif,selesai',
            'jumlah_hari' => 'required|integer|min:1|max:100',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroyClass(ClassModel $class)
    {
        $class->update(['is_archived' => true]);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function enrollStudents(Request $request)
    {
        $validated = $request->validate([
            'id_class' => 'required|exists:classes,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $class = ClassModel::findOrFail($validated['id_class']);
        $students = User::whereIn('id', $validated['student_ids'])->where('role', 'murid')->get();

        foreach ($students as $student) {
            if (!$class->students->contains($student)) {
                $class->students()->attach($student);
            }
        }

        return back()->with('success', 'Murid berhasil dimasukkan ke kelas.');
    }
}
