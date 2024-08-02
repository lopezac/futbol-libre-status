<?php
include "./header.php";
include $_SERVER["DOCUMENT_ROOT"] . "/futbol-libre-status/process/p-index.php";
?>

<?php
function format_url(string $full_url): string
{
    // TODO: habilitar http
    $url = explode("https://", $full_url)[1];
    return explode("/", $url)[0];
}

if (isset($pages) && count($pages)) {
    ?>
    <table class="w-100 shadow">
        <thead>
            <tr class='d-flex border border-secondary bg-secondary text-light'>
                <th class='col-1 ps-2 py-2 d-flex align-items-center border-end border-light' scope="col">Online</th>
                <th class='col-11 py-2 flex-grow-1 align-items-center d-flex ps-3' scope="col">URL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($pages as $page) {
                $offline_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-exclamation-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
  <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
</svg>';
                $online_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
  <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
</svg>';
                $online_td = "<td class='col-1 ps-3 text-success border-end border-secondary'>" . $online_icon. "</td>";
                $offline_td = "<td class='col-1 ps-3 text-danger border-end border-secondary'>" . $offline_icon. "</td>";
                echo "<tr class='d-flex border border-top-0 border-secondary'>";
                echo ($page["status"] ? $online_td : $offline_td);
                echo "<td class='col-11 flex-grow-1 align-items-center d-flex ps-3'><a class='text-decoration-none text-reset fw-semibold fs-6' href='"
                    . $page["url"] . "'>" . format_url($page["url"]) . "</a></td>";
                echo "</tr>";
            }
    }
    ?>
        </tbody>
    </table>

<?php
include "./footer.html";
?>