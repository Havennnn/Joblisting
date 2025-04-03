@extends('layouts.employer')

@section('title', 'Employer Dashboard')

@section('content')
<div class="bg-gray-100">
    <!-- Dashboard header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Job Posting</h1>
        </div>
    </header>

    <!-- Main content -->
    <main class="pt-6 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome section -->
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                        <p class="mt-1 text-sm text-gray-500">Manage your job listings and applicants here.</p>
                    </div>
                </div>
            </div>

            <h1 class="mb-0">Post Job</h1>
            <hr />
            <form action="{{ route('jobposts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <div class="col">
                        <label for="title">Job Title:</label>
                        <input type="text" name="title" class="form-control" placeholder="Job Title" required>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="col">
                        <label for="industry">Industry:</label>
                        <select name="industry" class="form-control" id="industry" placeholder="Select Industry" required>
                            <option>Technology and IT</option>
                            <option>Healthcare and Medical</option>
                            <option>Education and Training</option>
                            <option>Construction and Engineering</option>
                            <option>Finance and Banking</option>
                            <option>Retail and E-commerce</option>
                            <option>Hospitality and Tourism</option>
                            <option>Entertainment and Media</option>
                            <option>Manufacturing and Production</option>
                            <option>Transportation and Logistics</option>
                            <option>Energy and Utilities</option>
                            <option>Agriculture and Agribusiness</option>
                            <option>Marketing and Advertising</option>
                            <option>Real Estate</option>
                            <option>Legal and Compliance</option>
                            <option>Government and Public Administration</option>
                            <option>Food and Beverage</option>
                            <option>Arts and Design</option>
                            <option>Telecommunication</option>
                            <option>Science and Research</option>
                            <option>Others</option>
                        </select>
                    </div>

                    <div class="col">
                        <label for="role">Role:</label>
                        <select name="role" class="form-control" id="role" placeholder="Select Role" required>
                            <optgroup label="Technology and IT">
                                <option value="Software Developer/Engineer">Software Developer/Engineer</option>
                                <option value="Web Developer">Web Developer</option>
                                <option value="Mobile App Developer">Mobile App Developer</option>
                                <option value="IT Support Specialist">IT Support Specialist</option>
                                <option value="Data Analyst">Data Analyst</option>
                                <option value="Cybersecurity Specialist">Cybersecurity Specialist</option>
                                <option value="Cloud Engineer">Cloud Engineer</option>
                                <option value="DevOps Engineer">DevOps Engineer</option>
                                <option value="UX/UI Designer">UX/UI Designer</option>
                                <option value="Game Developer">Game Developer</option>
                                <option value="Database Administrator">Database Administrator</option>
                                <option value="AI/ML Engineer">AI/ML Engineer</option>
                                <option value="Blockchain Developer">Blockchain Developer</option>
                            </optgroup>
                            <optgroup label="Healthcare">
                                <option value="Doctor">Doctor</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Pharmacist">Pharmacist</option>
                                <option value="Physical Therapist">Physical Therapist</option>
                                <option value="Dentist">Dentist</option>
                                <option value="Medical Lab Technician">Medical Lab Technician</option>
                                <option value="Radiologist">Radiologist</option>
                                <option value="Nutritionist/Dietitian">Nutritionist/Dietitian</option>
                                <option value="Healthcare Administrator">Healthcare Administrator</option>
                                <option value="Psychiatrist/Psychologist">Psychiatrist/Psychologist</option>
                            </optgroup>
                            <optgroup label="Education">
                                <option value="Teacher">Teacher</option>
                                <option value="Professor/Lecturer">Professor/Lecturer</option>
                                <option value="Academic Advisor">Academic Advisor</option>
                                <option value="Curriculum Developer">Curriculum Developer</option>
                                <option value="Online Course Instructor">Online Course Instructor</option>
                                <option value="Special Education Teacher">Special Education Teacher</option>
                                <option value="Researcher">Researcher</option>
                            </optgroup>
                            <optgroup label="Business and Management">
                                <option value="Project Manager">Project Manager</option>
                                <option value="Business Analyst">Business Analyst</option>
                                <option value="Human Resources Specialist">Human Resources Specialist</option>
                                <option value="Operations Manager">Operations Manager</option>
                                <option value="Marketing Manager">Marketing Manager</option>
                                <option value="Sales Representative">Sales Representative</option>
                                <option value="Customer Service Representative">Customer Service Representative</option>
                                <option value="Product Manager">Product Manager</option>
                                <option value="Management Consultant">Management Consultant</option>
                            </optgroup>
                            <optgroup label="Creative and Design">
                                <option value="Graphic Designer">Graphic Designer</option>
                                <option value="Video Editor">Video Editor</option>
                                <option value="Animator">Animator</option>
                                <option value="Photographer">Photographer</option>
                                <option value="Interior Designer">Interior Designer</option>
                                <option value="Fashion Designer">Fashion Designer</option>
                                <option value="Writer/Content Creator">Writer/Content Creator</option>
                                <option value="Social Media Manager">Social Media Manager</option>
                                <option value="Illustrator">Illustrator</option>
                                <option value="Art Director">Art Director</option>
                            </optgroup>
                            <optgroup label="Engineering">
                                <option value="Civil Engineer">Civil Engineer</option>
                                <option value="Mechanical Engineer">Mechanical Engineer</option>
                                <option value="Electrical Engineer">Electrical Engineer</option>
                                <option value="Structural Engineer">Structural Engineer</option>
                                <option value="Aerospace Engineer">Aerospace Engineer</option>
                                <option value="Chemical Engineer">Chemical Engineer</option>
                                <option value="Robotics Engineer">Robotics Engineer</option>
                            </optgroup>
                            <optgroup label="Legal and Law Enforcement">
                                <option value="Lawyer/Attorney">Lawyer/Attorney</option>
                                <option value="Paralegal">Paralegal</option>
                                <option value="Legal Assistant">Legal Assistant</option>
                                <option value="Judge">Judge</option>
                                <option value="Police Officer">Police Officer</option>
                                <option value="Security Analyst">Security Analyst</option>
                                <option value="Forensic Analyst">Forensic Analyst</option>
                            </optgroup>
                            <optgroup label="Finance and Accounting">
                                <option value="Accountant">Accountant</option>
                                <option value="Financial Analyst">Financial Analyst</option>
                                <option value="Auditor">Auditor</option>
                                <option value="Investment Banker">Investment Banker</option>
                                <option value="Tax Consultant">Tax Consultant</option>
                                <option value="Actuary">Actuary</option>
                                <option value="Financial Advisor">Financial Advisor</option>
                            </optgroup>
                            <optgroup label="Hospitality and Tourism">
                                <option value="Hotel Manager">Hotel Manager</option>
                                <option value="Travel Agent">Travel Agent</option>
                                <option value="Tour Guide">Tour Guide</option>
                                <option value="Chef">Chef</option>
                                <option value="Event Planner">Event Planner</option>
                                <option value="Flight Attendant">Flight Attendant</option>
                            </optgroup>
                            <optgroup label="Media and Entertainment">
                                <option value="Journalist">Journalist</option>
                                <option value="News Anchor">News Anchor</option>
                                <option value="Actor">Actor</option>
                                <option value="Musician">Musician</option>
                                <option value="Film Director">Film Director</option>
                                <option value="Producer">Producer</option>
                                <option value="Scriptwriter">Scriptwriter</option>
                            </optgroup>
                            <optgroup label="Science and Research">
                                <option value="Research Scientist">Research Scientist</option>
                                <option value="Environmental Scientist">Environmental Scientist</option>
                                <option value="Biologist">Biologist</option>
                                <option value="Chemist">Chemist</option>
                                <option value="Physicist">Physicist</option>
                                <option value="Laboratory Technician">Laboratory Technician</option>
                                <option value="Astronomer">Astronomer</option>
                            </optgroup>
                            <optgroup label="Skilled Trades">
                                <option value="Electrician">Electrician</option>
                                <option value="Plumber">Plumber</option>
                                <option value="Carpenter">Carpenter</option>
                                <option value="Mechanic">Mechanic</option>
                                <option value="Welder">Welder</option>
                                <option value="Technician">Technician</option>
                                <option value="Machinist">Machinist</option>
                            </optgroup>
                            <optgroup label="Customer Service and Retail">
                                <option value="Retail Associate">Retail Associate</option>
                                <option value="Cashier">Cashier</option>
                                <option value="Call Center Agent">Call Center Agent</option>
                                <option value="Store Manager">Store Manager</option>
                                <option value="Personal Shopper">Personal Shopper</option>
                            </optgroup>
                            <optgroup label="Logistics and Supply Chain">
                                <option value="Logistics Coordinator">Logistics Coordinator</option>
                                <option value="Supply Chain Manager">Supply Chain Manager</option>
                                <option value="Warehouse Manager">Warehouse Manager</option>
                                <option value="Delivery Driver">Delivery Driver</option>
                            </optgroup>
                                <optgroup label="Freelancing and Self-Employment">
                                <option value="Freelancer">Freelancer</option>
                                <option value="Entrepreneur">Entrepreneur</option>
                                <option value="Consultant">Consultant</option>
                                <option value="Virtual Assistant">Virtual Assistant</option>
                                <option value="Others">Others</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="col">
                        <label for="job_description">Description:</label>
                        <textarea name="job_description" class="form-control" placeholder="Job Description" required></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="col">
                        <label for="qualifications">Qualifications:</label>
                        <textarea name="qualifications" class="form-control" placeholder="Qualifications" required></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="col">
                        <label for="starting_date">Starting Date:</label>
                        <input type="date" name="starting_date" class="form-control">
                    </div>

                    <div class="col">
                        <label for="expiration_date">Expiration Date:</label>
                        <input type="date" name="expiration_date" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="col">
                        <label for="work_experience_level">Work Experience Level:</label>
                        <select name="work_experience_level" class="form-control" id="work_experience_level" required>
                            <option>Entry-Level</option>
                            <option>Junior-Level</option>
                            <option>Mid-Level</option>
                            <option>Senior-Level</option>
                            <option>Managerial</option>
                            <option>Executive-Level</option>
                            <option>Freelancer</option>
                            <option>Internship</option>
                        </select>
                    </div>

                    <div class="col">
                        <label for="educational_level">Educational Level:</label>
                        <select name="educational_level" class="form-control" id="educational_level" required>
                            <option>Junior High</option>
                            <option>Senior High</option>
                            <option>Certificate or Diploma Courses</option>
                            <option>Trade/Technical School</option>
                            <option>Associate Degree</option>
                            <option>Bachelor’s Degree</option>
                            <option>Master’s Degree</option>
                            <option>Doctorate</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="col">
                        <label for="work_setup">Work Setup:</label>
                        <select name="work_setup" class="form-control" id="work_setup" required>
                            <option>On-Site</option>
                            <option>Remote</option>
                            <option>Hybrid</option>
                        </select>
                    </div>

                    <div class="col">
                        <label for="shift">Shift:</label>
                        <select name="shift" class="form-control" id="shift">
                            <option>Day shift</option>
                            <option>Mid shift</option>
                            <option>Night shift</option>
                        </select>
                    </div>

                    <div class="col">
                        <label for="type">Contract Type:</label>
                        <select name="type" class="form-control" id="type" required>
                            <option>Full time</option>
                            <option>Part time</option>
                            <option>Freelance</option>
                        </select>
                    </div>
                </div>


                <div class="mb-3">
                    <div class="col">
                        <label for="location">Location:</label>
                        <input type="text" name="location" class="form-control" placeholder="Location" required>
                    </div>

                    <div class="col">
                        <label for="salary">Salary:</label>
                        <input type="number" name="salary" class="form-control" placeholder="Salary">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="col">
                        <label for="vacancies">Vacancies:</label>
                        <input type="number" name="vacancies" class="form-control" placeholder="Vacancies">
                    </div>

                    <div class="col">
                        <label for="tags">Tag:</label>
                        <select name="tags" class="form-control" id="tags">
                            <option>Urgent</option>
                            <option>Mass hiring</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
