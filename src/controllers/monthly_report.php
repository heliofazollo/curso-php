<?php
session_start();
requireValidSession();

$currentdate = new DateTime();

$user = $_SESSION['user'];
$selectedUserId = $user->id;
$users = null;
if($user->is_admin) {
    $users = User::get();
    if (!$user) {
      $selectedUserId = $_POST['user'] ? $_POST['user'] : $user->id;
    }
}

$selectedPeriod = isset($_POST['period']) ? $_POST['period'] : $currentdate->format('Y-m');
$periods = [];
for($yearDiff = 0; $yearDiff <= 2; $yearDiff++) {
    $year = date('Y') - $yearDiff;
    for($month = 12; $month >= 1; $month--) {
        $date = new DateTime("{$year}-{$month}-1");
        $periods[$date->format('Y-m')] = strftime('%B de %Y', $date->getTimestamp());
    }
}
//$registries = WorkingHours::getMonthlyReport($user->id, new DateTime());
$registries = WorkingHours::getMonthlyReport($selectedUserId, $selectedPeriod);

$report = [];
$workDay = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastDayOfMonth($currentdate)->format('d');
$date = null;

for($day = 1; $day <= $lastDay; $day++) {
    $date = $currentdate->format('Y-m') . '-' . sprintf('%02d', $day);
    $registry = isset($registries[$date]) ? $registries[$date] : null;


    if(isPastWorkday($date)) $workDay++;

    if($registry) {
        $sumOfWorkedTime += $registry->worked_time;
        array_push($report, $registry);
    } else {
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
    'sumOfWorkedTime' => getTimeStringFromSeconds($sumOfWorkedTime),
    'balance' => "{$sign}{$balance}",
    'selectedPeriod' => $selectedPeriod,
    'periods' => $periods,
    'selectedUserId' => $selectedUserId,
    'users' => $users,
]);
