<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CICT Alumni Registration</title>

<!-- Bootstrap + Icons + Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-image: url('/images/bulsu.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-sizing: border-box;
    }

    body::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(30, 58, 138, 0.85);
        z-index: 0;
    }

    .form-container {
        position: relative;
        z-index: 1;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        padding: 25px 30px;
        width: 95%;
        max-width: 650px;
        overflow-y: auto;
        max-height: 95vh;
        box-sizing: border-box;
    }

    h2 {
        font-weight: 700;
        text-align: center;
        color: #1e3a8a;
        font-size: 1.7rem;
        margin-bottom: 1.5rem;
    }

    h4.section-header {
        font-weight: 700;
        color: #1e3a8a;
        margin-top: 20px;
        margin-bottom: 10px;
        border-bottom: 2px solid #1e3a8a;
        padding-bottom: 3px;
    }

    label {
        font-weight: 600;
        color: #1e3a8a;
        font-size: 0.95rem;
        margin-bottom: 4px;
    }

    input, select {
        border-radius: 6px !important;
        border: 1px solid #ccc;
        font-size: 0.95rem;
        padding: 8px 10px;
        height: auto;
        box-sizing: border-box;
        width: 100%;
    }

    .btn {
        border-radius: 6px;
        background-color: #1e3a8a;
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        padding: 8px 16px;
        transition: 0.3s;
    }

    .btn-success {
        background-color: #28a745;
    }

    .center-checkbox label {
        font-size: 0.9rem;
    }

    .show-password {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 5px;
    }

    @media (max-width: 500px) {
        .form-container {
            padding: 15px 20px;
        }
        h2 {
            font-size: 1.4rem;
        }
        label, input, select, .btn {
            font-size: 0.9rem;
        }
    }
</style>
</head>
<body>
<div class="form-container">
    <h2><i class="fa-solid fa-user-graduate me-2"></i>Alumni Registration</h2>

    @if(session('error'))
        <div class="alert alert-danger text-center py-1 mb-2">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success text-center py-1 mb-2">{{ session('success') }}</div>
    @endif

    <!-- Step 0: Masterlist Check -->
    <div id="step0Fields">
        <h4 class="section-header">Verify Identity</h4>
        <div class="center-checkbox">
            <input type="checkbox" class="form-check-input" id="useFullNameCheckbox">
            <label for="useFullNameCheckbox">Register using Full Name + Birthdate</label>
        </div>

        <div class="mb-3" id="studentNumberDiv">
            <label for="student_number" class="form-label">Student Number</label>
            <input type="text" class="form-control" id="student_number" name="student_number">
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name *</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>

        <div class="mb-3" id="firstNameDiv" style="display:none;">
            <label for="first_name" class="form-label">First Name *</label>
            <input type="text" class="form-control" id="first_name" name="first_name">
        </div>

        <div class="mb-3" id="birthdateDiv" style="display:none;">
            <label for="birthdate" class="form-label">Birthdate *</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate">
        </div>

        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('landing') }}" class="btn btn-secondary" id="step0BackBtn">Back</a>
            <button type="button" class="btn btn-primary" id="checkMasterlistBtn">Check Masterlist</button>
        </div>
    </div>

    <!-- Step 1: Registration form -->
    <form id="registrationForm" method="POST" action="{{ route('alumni.register.submit') }}" style="display:none;">
        @csrf

        <h4 class="section-header">Personal Information</h4>
        <div class="mb-3">
            <label for="student_number_field" class="form-label">Student Number</label>
            <input type="text" class="form-control" id="student_number_field" name="student_number" readonly>
        </div>
        <div class="mb-3">
            <label for="first_name_field" class="form-label">First Name *</label>
            <input type="text" class="form-control" id="first_name_field" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="middle_name_field" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name_field" name="middle_name">
        </div>
        <div class="mb-3">
            <label for="last_name_field" class="form-label">Last Name *</label>
            <input type="text" class="form-control" id="last_name_field" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="auxiliary_name_field" class="form-label">Auxiliary Name</label>
            <input type="text" class="form-control" id="auxiliary_name_field" name="auxiliary_name">
        </div>
        <div class="mb-3">
            <label for="birthdate_field" class="form-label">Birthdate *</label>
            <input type="date" class="form-control" id="birthdate_field" name="birthdate" required>
        </div>
        <div class="mb-3">
            <label for="gender_field" class="form-label">Gender *</label>
            <select class="form-select" id="gender_field" name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <h4 class="section-header">Academic & Employment</h4>
        <div class="mb-3">
            <label for="civil_status" class="form-label">Civil Status *</label>
            <select class="form-select" id="civil_status" name="civil_status" required>
                <option value="">-- Select Civil Status --</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Widowed">Widowed</option>
                <option value="Separated">Separated</option>
                <option value="Divorced">Divorced</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="employment_status" class="form-label">Employment Status *</label>
            <select class="form-select" id="employment_status" name="employment_status" required>
                <option value="">-- Select Employment Status --</option>
                <option value="Employed">Employed</option>
                <option value="Self-Employed">Self-Employed</option>
                <option value="Unemployed">Unemployed</option>
                <option value="Student">Student</option>
                <option value="Retired">Retired</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="answered_alumni_tracer" class="form-label">Have you answered the Alumni Tracer? *</label>
            <select class="form-select" id="answered_alumni_tracer" name="answered_alumni_tracer" required>
                <option value="">-- Select --</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="program" class="form-label">Program *</label>
            <select class="form-select" id="program" name="programID" required>
                <option value="">-- Select Program --</option>
                @foreach($programs as $program)
                    <option value="{{ $program->programID }}">{{ $program->program_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="specializationDiv" style="display:none;">
            <label for="specialization" class="form-label">Specialization</label>
            <select class="form-select" id="specialization" name="specializationID">
                <option value="">-- Select Specialization --</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec->specializationID }}">{{ $spec->specialization_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="graduation_year_field" class="form-label">Graduation Year *</label>
            <input type="number" class="form-control" id="graduation_year_field" name="graduation_year" required>
        </div>

        <h4 class="section-header">Contact Information</h4>
        <div class="mb-3">
            <label for="address" class="form-label">Address *</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Street, Barangay, etc." required>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Country *</label>
            <select class="form-select" id="country" name="country" required>
                <option value="">-- Select Country --</option>
                <option value="Philippines">Philippines</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <div id="philippinesFields">
            <div class="mb-3">
                <label for="region" class="form-label">Region *</label>
                <select class="form-select" id="region" name="region" required>
                    <option value="">-- Select Region --</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="province" class="form-label">Province *</label>
                <select class="form-select" id="province" name="province" required>
                    <option value="">-- Select Province --</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">City/Municipality *</label>
                <select class="form-select" id="city" name="city" required>
                    <option value="">-- Select City --</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="postal_code" class="form-label">Postal Code *</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
        </div>

        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number *</label>
            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="09XXXXXXXXX" required>
        </div>

        <h4 class="section-header">Account Credentials</h4>
        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password *</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password *</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="privacy" name="privacy" required>
            <label class="form-check-label" for="privacy">I accept the privacy policy *</label>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <!-- Back Button -->
            <a href="{{ route('landing') }}" class="btn btn-secondary">Back</a>
        
            <!-- Register Button -->
            <button type="submit" class="btn btn-success">Register</button>
        </div>
        
        <!-- Already have an account link -->
        <div class="text-center mt-2">
            <a href="{{ route('alumni.login') }}">Already have an account? Login here</a>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const programSelect = document.getElementById('program');
    const specializationDiv = document.getElementById('specializationDiv');
    const checkBtn = document.getElementById('checkMasterlistBtn');
    const useFullNameCheckbox = document.getElementById('useFullNameCheckbox');
    const step0Fields = document.getElementById('step0Fields');
    const registrationForm = document.getElementById('registrationForm');
    const studentNumberDiv = document.getElementById('studentNumberDiv');
    const firstNameDiv = document.getElementById('firstNameDiv');
    const birthdateDiv = document.getElementById('birthdateDiv');

    // --- Toggle Masterlist Input Method ---
    useFullNameCheckbox.addEventListener('change', () => {
        const useFullName = useFullNameCheckbox.checked;
        studentNumberDiv.style.display = useFullName ? 'none' : 'block';
        firstNameDiv.style.display = useFullName ? 'block' : 'none';
        birthdateDiv.style.display = useFullName ? 'block' : 'none';
    });

    // --- Toggle Specialization based on Program ---
    function toggleSpecialization() {
        const selectedProgramText = programSelect.options[programSelect.selectedIndex].text;
        specializationDiv.style.display = (selectedProgramText === 'BSIT') ? 'block' : 'none';
    }
    programSelect.addEventListener('change', toggleSpecialization);

    // --- Masterlist Check ---
    checkBtn.addEventListener('click', () => {
        const student_number = document.getElementById('student_number').value;
        const last_name = document.getElementById('last_name').value;
        const first_name = document.getElementById('first_name').value;
        const birthdate = document.getElementById('birthdate').value;
        const use_fullname = useFullNameCheckbox.checked;

        fetch("{{ route('verify.masterlist') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                student_number, last_name, first_name, birthdate, use_fullname
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const info = data.data;
                document.getElementById('student_number_field').value = info.student_number;
                document.getElementById('first_name_field').value = info.first_name;
                document.getElementById('middle_name_field').value = info.middle_name ?? '';
                document.getElementById('last_name_field').value = info.last_name;
                document.getElementById('birthdate_field').value = info.birthdate;
                document.getElementById('gender_field').value = info.gender;
                document.getElementById('graduation_year_field').value = info.graduation_year;
                programSelect.value = info.programID;

                toggleSpecialization(); // show specialization if BSIT
                if (specializationDiv.style.display === 'block') {
                    document.getElementById('specialization').value = info.specializationID;
                }

                step0Fields.style.display = 'none';
                registrationForm.style.display = 'block';
            } else {
                alert(data.message || 'No record found.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error checking masterlist.');
        });
    });

    // --- Region → Province → City using PSGC API ---
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');

    // Load regions
    fetch('https://psgc.gitlab.io/api/regions/')
        .then(res => res.json())
        .then(regions => {
            regions.sort((a,b) => a.name.localeCompare(b.name));
            regions.forEach(region => {
                const opt = document.createElement('option');
                opt.value = region.code;
                opt.textContent = region.name;
                regionSelect.appendChild(opt);
            });
        })
        .catch(err => console.error('Failed to load regions:', err));

    regionSelect.addEventListener('change', () => {
        provinceSelect.innerHTML = '<option value="">-- Select Province --</option>';
        citySelect.innerHTML = '<option value="">-- Select City --</option>';
        const regionCode = regionSelect.value;
        if(!regionCode) return;

        fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`)
            .then(res => res.json())
            .then(provinces => {
                provinces.sort((a,b) => a.name.localeCompare(b.name));
                provinces.forEach(province => {
                    const opt = document.createElement('option');
                    opt.value = province.code;
                    opt.textContent = province.name;
                    provinceSelect.appendChild(opt);
                });
            })
            .catch(err => console.error('Failed to load provinces:', err));
    });

    provinceSelect.addEventListener('change', () => {
        citySelect.innerHTML = '<option value="">-- Select City --</option>';
        const provinceCode = provinceSelect.value;
        if(!provinceCode) return;

        fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`)
            .then(res => res.json())
            .then(cities => {
                cities.sort((a,b) => a.name.localeCompare(b.name));
                cities.forEach(city => {
                    const opt = document.createElement('option');
                    opt.value = city.name;
                    opt.textContent = city.name;
                    citySelect.appendChild(opt);
                });
            })
            .catch(err => console.error('Failed to load cities:', err));
    });

    // --- Show/Hide Password ---
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation')

    function addShowPassword(field) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('input-group');
        field.parentNode.insertBefore(wrapper, field);
        wrapper.appendChild(field);

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-outline-secondary';
        btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        wrapper.appendChild(btn);

        btn.addEventListener('click', () => {
            if(field.type === 'password') {
                field.type = 'text';
                btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
            } else {
                field.type = 'password';
                btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            }
        });
    }

    addShowPassword(passwordField);
    addShowPassword(confirmPasswordField);
});
</script>

</body>
</html>
