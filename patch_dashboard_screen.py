import re

with open(r"C:\project pkm\bio_guard\lib\ui\screens\dashboard_screen.dart", "r", encoding="utf-8") as f:
    content = f.read()

pattern = r"class RouteDetail \{[\s\S]*?\} \/\/[^\n]*\n?"
# Wait, it ends with `};\n`
pattern = r"class RouteDetail \{[\s\S]*?^\};\n"
content = re.sub(pattern, "", content, flags=re.MULTILINE)

with open(r"C:\project pkm\bio_guard\lib\ui\screens\dashboard_screen.dart", "w", encoding="utf-8") as f:
    f.write(content)
print("Updated dashboard_screen.dart again")
