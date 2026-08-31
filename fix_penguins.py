import re

files = [
    r'resources/views/dashboard/simulator.blade.php',
    r'resources/views/simulator.blade.php'
]

svg_icon = '''<svg id="critical-penguin-img" class="w-full h-full text-white filter drop-shadow-[0_0_15px_rgba(239,68,68,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>'''

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    content = re.sub(r'<img id="critical-penguin-img"[^>]+>', svg_icon, content)
    
    # regex to remove img.src lines
    content = re.sub(r'img\.src\s*=\s*".*?penguin_.*?";', '', content)
    
    content = content.replace(
        "img.className = 'w-full h-full object-contain filter drop-shadow-[0_0_15px_rgba(6,182,212,0.8)]';",
        "img.className = 'w-full h-full text-white filter drop-shadow-[0_0_15px_rgba(6,182,212,0.8)]';"
    )
    content = content.replace(
        "img.className = 'w-full h-full object-contain filter drop-shadow-[0_0_15px_rgba(239,68,68,0.8)]';",
        "img.className = 'w-full h-full text-white filter drop-shadow-[0_0_15px_rgba(239,68,68,0.8)]';"
    )
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print("Replaced penguins with SVG in " + filepath)

