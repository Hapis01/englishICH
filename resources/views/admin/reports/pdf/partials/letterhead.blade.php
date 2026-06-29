<div class="header">
    <table>
        <tr>
            <td width="80"><img src="{{ public_path('images/logoich.png') }}" style="width:70px; height:70px; object-fit:contain;"></td>
            <td>
                <h1 class="company-name">English Club ICH Medan</h1>
                <p class="company-details">Jl. Datuk Kabu Gg. Ridho No. 11 E Deli Serdang<br>Phone: +62 61 123 4567 | Email: ichenglish@gmail.com</p>
            </td>
            <td class="doc-no" width="150" valign="top">
                Document No.
                <span>{{ $docNo ?? 'RPT/' . date('Y') . '/000' }}</span>
            </td>
        </tr>
    </table>
</div>
