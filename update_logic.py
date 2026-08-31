# -*- coding: utf-8 -*-
import os

files = [
    r"resources/views/simulator.blade.php",
    r"resources/views/dashboard/simulator.blade.php"
]

for filepath in files:
    if os.path.exists(filepath):
        with open(filepath, "r", encoding="utf-8") as f:
            content = f.read()
            
        old_if = "else if (temperature > 8.5) {"
        new_if = "else if (temperature > 8.5 || temperature < 2.0) {"
        if old_if in content:
            content = content.replace(old_if, new_if)
            
        old_btn_aman = '<button onclick="setTemperature(4.5)" class="py-1 rounded bg-slate-800/80 border border-white/5 hover:bg-slate-800 hover:text-white transition text-emerald-400">4.5°C (Aman)</button>'
        new_btn_aman = '<button onclick="setTemperature(4.5)" class="py-1 rounded bg-slate-800/80 border border-white/5 hover:bg-slate-800 hover:text-white transition text-emerald-400">Suhu Aman (4.5°C)</button>\n<button onclick="setTemperature(8.3)" class="py-1 rounded bg-slate-800/80 border border-white/5 hover:bg-slate-800 hover:text-white transition text-amber-400">Warning (8.3°C)</button>\n</div>\n<div class="grid grid-cols-2 gap-2 text-[10px] font-semibold text-center mt-2">\n<button onclick="setTemperature(10.5)" class="py-1 rounded bg-slate-800/80 border border-white/5 hover:bg-slate-800 hover:text-white transition text-rose-500">Kritis (10.5°C)</button>\n<button onclick="setTemperature(1.5)" class="py-1 rounded bg-slate-800/80 border border-white/5 hover:bg-slate-800 hover:text-white transition text-cyan-400">Beku (1.5°C)</button>'
                            
        # Replace the grid-cols-3
        content = content.replace('<div class="grid grid-cols-3 gap-2 text-[10px] font-semibold text-center mt-1">', '<div class="grid grid-cols-2 gap-2 text-[10px] font-semibold text-center mt-1">')
        
        # We need to remove the existing buttons and replace them cleanly
        if old_btn_aman in content:
            # wait, I should just use regex to replace the entire buttons container
            import re
            pattern_btns = r'<button onclick="setTemperature\(4\.5\).*?<button onclick="setTemperature\(10\.5\)[^>]*>10\.5°C \(Kritis\)</button>'
            content = re.sub(pattern_btns, new_btn_aman, content, flags=re.DOTALL)
            
        with open(filepath, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"Fixed extreme excursion logic in {filepath}")
