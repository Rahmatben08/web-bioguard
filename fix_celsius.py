import os
import glob

def replace_in_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if '┬░' in content:
        content = content.replace('┬░', '°')
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Fixed: {filepath}")

for filepath in glob.glob('resources/views/**/*.blade.php', recursive=True):
    replace_in_file(filepath)

