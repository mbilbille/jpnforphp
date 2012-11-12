<?php

global $check; $check = array("success" => 0, "error" => 0);

function __autoload($classname)
{
    require_once '../src/'. $classname . '.php';
}

function unit($function, $inputs, $expected_result, $grp)
{
    global $check;
    $fn_time_start = microtime(true);
    set_error_handler('errorHandler');
    try {
        $result = call_user_func_array($function, $inputs);
        if ($result === $expected_result) {
            $css = "success";
        } else {
            $css = "error";
            $check[$grp] = 'danger';
        }
    } catch (Exception $e) {
        $result = $e->getMessage();
        $css = "error";
        $check[$grp] = 'danger';
    }
    $check[$css]++;
    $output = '<tr class="' . $css . '">
    <td>' . implode(' | ', $inputs) . '</td>
    <td>' . var_export($expected_result, true) . '</td>
    <td>' . var_export($result, true) . '</td>
    <td class="timer">' . number_format((microtime(true) - $fn_time_start), 10) . '</td>
    </tr>';

    return $output;
}

function process($data)
{
    global $check;
    $output = '<table class="table table-bordered"><thead>
    <tr><th>Inputs</th><th>Expected results</th><th>Results</th><th>Time</th></tr>
    </thead><tbody>';

    foreach ($data['functions'] as $fn => $groups) {

        foreach ($groups as $i => $group) {

            $grp_output = '';
            $check[$i] = 'success';

            foreach ($group['cases'] as $case) {

                $grp_output .= unit($data['namespace'].'::'.$fn, $case['input'], $case['expected'], $i);
            }

            $output .= '<tr><td colspan="4" class="heading"><button class="btn btn-small btn-info">Function '.$fn.'()</button>
            <button class="btn btn-small btn-'.$check[$i].'">'.$group['description'].'</button></td></tr>' . $grp_output;
        }
    }

    $output .= '</tbody></table>
    <span id="check-success" class="invisible">'.$check['success'].'</span>
    <span id="check-error" class="invisible">'.$check['error'].'</span>';

    return $output;
}

function errorHandler($errno, $errstr, $errfile, $errline)
{
  if (E_RECOVERABLE_ERROR===$errno) {
    print '<div class="alert alert-warning">'.$errstr.'</div>';

    return true;
  }
  print '<div class="alert alert-error">'.$errstr.'</div>';

  return false;
}
