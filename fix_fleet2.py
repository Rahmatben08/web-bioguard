with open(r"app/Http/Controllers/FleetController.php", "r", encoding="utf-8") as f:
    content = f.read()

old_block = """        $perjalananList = $query->get()
            ->map(function ($perjalanan) use ($initialLoad) {"""

new_block = """        $perjalananList = $perjalananAktif
            ->map(function ($perjalanan) use ($initialLoad) {"""

if old_block in content:
    content = content.replace(old_block, new_block)
    with open(r"app/Http/Controllers/FleetController.php", "w", encoding="utf-8") as f:
        f.write(content)
    print("Fixed FleetController.php second query bug!")
else:
    print("Could not find the block in FleetController.php")
