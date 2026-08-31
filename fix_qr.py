with open(r'resources/views/dashboard/audit_pdf.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Change QR Code to contain a URL
old_qr = """$hashData = 'bg_cdob_audit_' . date('Ymd_His') . '_' . (auth()->user()->dispatcher_id ?? 'DSP-PLB-2026');
                        $qrCode = SimpleSoftwareIO\\QrCode\\Facades\\QrCode::size(80)
                            ->color(15, 23, 42)
                            ->backgroundColor(255, 255, 255)
                            ->margin(1)
                            ->generate($hashData);"""
new_qr = """$hashData = 'bg_cdob_audit_' . date('Ymd_His') . '_' . (auth()->user()->dispatcher_id ?? 'DSP-PLB-2026');
                        $hashHex = hash('sha256', $hashData);
                        $verifyUrl = url('/verify/' . substr($hashHex, 0, 16));
                        $qrCode = SimpleSoftwareIO\\QrCode\\Facades\\QrCode::size(80)
                            ->color(15, 23, 42)
                            ->backgroundColor(255, 255, 255)
                            ->margin(1)
                            ->generate($verifyUrl);"""
content = content.replace(old_qr, new_qr)

# Fix the display text from "SHA256 INTEGRITY HASH" to something friendly
old_hash = """<p class="text-[10px] text-slate-400">SHA256 INTEGRITY HASH:</p>
                        <p class="text-[9px] font-bold text-slate-700 break-all select-all">{{ hash('sha256', $hashData) }}</p>"""
new_hash = """<p class="text-[10px] text-slate-400">NOMOR SERI AUDIT:</p>
                        <p class="text-[11px] font-bold text-slate-700 break-all select-all">{{ strtoupper(substr($hashHex, 0, 16)) }}</p>"""
content = content.replace(old_hash, new_hash)

# Add route ID tracking
content = content.replace("bg_cdob_audit_'", "bg_cdob_audit_' . implode('-', $perjalananList->pluck('id_rute')->toArray()) . '_'")

with open(r'resources/views/dashboard/audit_pdf.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated audit_pdf")
