for filepath in [r"resources/views/dashboard/simulator.blade.php", r"resources/views/simulator.blade.php"]:
    with open(filepath, "r", encoding="utf-8") as f:
        content = f.read()

    # Fix the catch block to delete the cache key so it retries
    old_catch = """    } catch (e) {
        console.error("OSRM Fetch Error", e);
    }
    return null;"""

    new_catch = """    } catch (e) {
        console.error("OSRM Fetch Error", e);
        delete routeCache[cacheKey];
    }
    return null;"""

    content = content.replace(old_catch, new_catch)

    with open(filepath, "w", encoding="utf-8") as f:
        f.write(content)
print("Fixed route cache bug in simulators")
