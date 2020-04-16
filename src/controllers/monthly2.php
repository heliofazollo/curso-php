<?php
session_start();
requireValidSession();

$currentdate = new DateTime();

$user = $_SESSION['user'];

$registries = WorkingHours::getMonthlyReport($user->id, new DateTime());

$report = [];
$workDay = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastDayOfMonth($currentdate)->format('d');

for ($day = 1; $day <= $lastDay; $day++) {
  $date = $currentdate->format('Y-m') . '-' . sprintf('%02d', $day);
  $registry = $registries[$date];

  if (isPastWorkDay($date)) $workDay++;

  if ($registry) {
    $sumOfWorkedTime += $registry->worked_time;
    array_push($report, $registry);
  }else {
    array_push($report, new WorkingHours([
      'work_date' => $date,
      'worked_time' => 0
    ]));
  }
}

$expectedTime = $workDay * DAILY_TIME;
$balance = getTimeStringFromSeconds(abs($sumOfWorkedTime - $expectedTime));
$sign = ($sumOfWorkedTime >= $expectedTime) ? '+' : '-';

loadTemplateView('monthly_report', [
  'report' => $report,
  '$sumOfWorkedTime' => $sumOfWorkedTime,
  'balance' => "{$sign}{$balance}"
]);

 ?>
