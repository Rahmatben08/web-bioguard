const fs = require('fs');

// Read the new OSRM routes
const newPaths = fs.readFileSync('C:/project pkm/bio_guard_backend/planned_paths_osrm.js', 'utf8');

// Read monitoring blade
let blade = fs.readFileSync('C:/project pkm/bio_guard_backend/resources/views/dashboard/monitoring.blade.php', 'utf8');

// Find the plannedPaths block and replace it
const startMarker = '    const plannedPaths = {';
const startIdx = blade.indexOf(startMarker);

if (startIdx === -1) {
    console.log('ERROR: plannedPaths not found!');
    process.exit(1);
}

// Find the matching closing }; after the opening {
let depth = 0;
let endIdx = startIdx;
let foundStart = false;
for (let i = startIdx; i < blade.length; i++) {
    if (blade[i] === '{') { depth++; foundStart = true; }
    if (blade[i] === '}') { 
        depth--; 
        if (foundStart && depth === 0) { 
            // Check for semicolon after
            endIdx = i + 1;
            if (blade[endIdx] === ';') endIdx++;
            break; 
        } 
    }
}

const oldBlock = blade.substring(startIdx, endIdx);
console.log('Old block length:', oldBlock.length);
console.log('Old block starts with:', oldBlock.substring(0, 80));
console.log('Old block ends with:', oldBlock.substring(oldBlock.length - 40));

// Build new block with proper indentation
const newBlock = '    ' + newPaths.trim();
console.log('New block length:', newBlock.length);

blade = blade.substring(0, startIdx) + newBlock + blade.substring(endIdx);

fs.writeFileSync('C:/project pkm/bio_guard_backend/resources/views/dashboard/monitoring.blade.php', blade, 'utf8');
console.log('SUCCESS: plannedPaths replaced!');
