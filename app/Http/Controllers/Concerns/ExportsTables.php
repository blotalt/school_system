<?php

namespace App\Http\Controllers\Concerns;

use Dompdf\Dompdf;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportsTables
{
    protected function exportCsv(string $filename, array $headers, iterable $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows) {
            $out = fopen('php://output', 'w');
            // Excel needs a UTF-8 BOM to render non-ASCII names correctly.
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $headers);

            foreach ($rows as $row) {
                fputcsv($out, $row);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    protected function exportPdf(string $filename, string $title, array $headers, iterable $rows): Response
    {
        $html = view('exports.pdf-table', [
            'title'       => $title,
            'headers'     => $headers,
            'rows'        => $rows,
            'generatedAt' => now()->format('F j, Y g:i A'),
        ])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('a4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
