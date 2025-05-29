<!DOCTYPE html>
<html lang="en" class="bg-[--background] text-[--foreground]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[--background] h-screen overflow-hidden flex">
  <!-- Sidebar: fixed width, full height, scrollable -->
  <aside class="w-64 bg-[--card] border-r border-[--border] h-full overflow-y-auto">
    @include('include.adminSideBar')
  </aside>

  <!-- Main content: fills remaining space, centers card -->
  <main class="flex-1 flex items-center justify-center p-6 overflow-auto">
    <div class="w-full max-w-xl bg-[--card] rounded-[--radius] shadow-md p-6">
      <h2 class="text-3xl font-semibold text-[--foreground] mb-6 text-center">Student Profile</h2>

      <div class="space-y-4 text-[--foreground] text-lg">
        <p><strong>Name:</strong> {{ $studentInfo->user->fname }} {{ $studentInfo->user->lname }}</p>
        <p><strong>Major:</strong> {{ $studentInfo->major }}</p>
        <p><strong>Expected Graduation:</strong> {{ $studentInfo->expected_graduation }}</p>
        <p><strong>GPA:</strong> {{ $studentInfo->gpa }}</p>
        <p><strong>Year:</strong> {{ $studentInfo->year }}</p>
        <p><strong>Number of trainings:</strong> {{ $studentInfo->number_of_training }}</p>
        <p><strong>Volunteerings:</strong> {{ $studentInfo->number_of_volunteering }} hours</p>
        <!-- etc. add whatever fields you need -->
      </div>

      <div class="mt-6 text-center">
        <a href="{{ url()->previous() }}"
           class="inline-block bg-[--secondary] text-[--secondary-foreground] px-6 py-2 rounded hover:bg-[--secondary-foreground] hover:text-[--secondary] transition">
           ← Back to Applications
        </a>
      </div>
    </div>
  </main>
</body>
</html>
