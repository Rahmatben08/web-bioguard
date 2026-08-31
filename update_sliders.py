import os

files = [
    r"resources/views/simulator.blade.php",
    r"resources/views/dashboard/simulator.blade.php"
]

for filepath in files:
    if os.path.exists(filepath):
        with open(filepath, "r", encoding="utf-8") as f:
            content = f.read()
            
        content = content.replace('min="0" max="15"', 'min="-20" max="60"')
        content = content.replace('min="0.0" max="15.0"', 'min="-20" max="60"')
        
        with open(filepath, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"Updated sliders in {filepath}")
