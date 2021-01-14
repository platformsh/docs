const fs = require('fs');
const yaml = require('js-yaml');
const request = require("request");

// Example file data.
const dataDirectories = {
    "templates": {
        dir: 'data/remote-examples/templates/',
        fetchFunc: fetchFilesTemplates,
    },
    "language-examples": {
        dir: 'data/remote-examples/language-examples/',
        fetchFunc: fetchFilesExamples
    }
}

// Ensure subdirectory we're saving to exists.
function ensureSubdir(savePath) {
    var destinationDir = process.cwd() + savePath
    if (!fs.existsSync(destinationDir)){
        // Create subdirectory if doesn't exist.
        fs.mkdirSync(destinationDir);
    }
}

// Function to place the request and write to the file.
function writeFileFromTarget(target, destination) {
    // Get the file.
    request.get(target, (error, response, body) => {
        // Write the file, ensuring type='string' in body (which is a problem on some examples).
        var finalBody;
        if (!(typeof body == 'string')) {
            finalBody = new String(body);
            console.log(`
* ${target}:
    - target: ${target}
    - destination: ${destination}
    - body: ${typeof body }
    - finalBody: ${typeof finalBody}
            `)
        } else {
            console.log(`
* ${target}:
    - OK. Strings all the way down.
            `)
            finalBody = body;
        }

//         console.log(`
// * ${target}:
//     - isString(target): ${typeof target == 'string'}
//     - isString(destination): ${typeof destination == 'string'}
//     - body: ${typeof body }
//     - finalBody: ${typeof finalBody}

//         `)
        fs.writeFileSync(destination, finalBody);
    })
}

// Function to parse out an example file's target and destination before request is made.
function fetchFilesTemplates(data) {
    for ( repo in data["repos"] ) {
        // Format target and destination.
        var target = `${data["root"]}/${data["repos"][repo]}/${data["branch"]}/${data["file"]}`;
        var destination = process.cwd() + `${data["savePath"]}/${data["repos"][repo]}`
        // Ensure subdirectory exists.
        ensureSubdir(data["savePath"]);
        writeFileFromTarget(target, destination);

    }
}

// Function to parse out an example file's target and destination before request is made.
function fetchFilesExamples(data) {
    // Ensure that the examples subdirectory exists.
    ensureSubdir(data["savePath"]);
    for ( language in data["paths"] ) {
        // Format target and destination for each language.
        var languageTargetDir = `${data["root"]}/${language}`;
        var languageDestDir = `${data["savePath"]}/${language}`;
        // Ensure the language subdirectory exists.
        ensureSubdir(languageDestDir)
        for ( service in data["paths"][language] ) {
            // Format target and destination for each service.
            var target = `${languageTargetDir}/${data["paths"][language][service]}`;
            var destination = process.cwd() + `${languageDestDir}/${data["paths"][language][service]}`;
//             console.log(`
// * ${data["paths"][language][service]}            
//     - target: ${target}
//     - destination: ${destination} 

//             `)
        // if(fs.existsSync(target)) {
        //     console.log(`The file ${target} already exists. Skipping.`);
        // } else {
        //     console.log('The file does not exist.');
        //     // Place the request and write the file.
        //     writeFileFromTarget(target, destination);
        // }
            // Place the request and write the file.
            writeFileFromTarget(target, destination);
        }
    }
}

// Main fetch function.
function fetch(exampleGroup) {
    // Get data for the current group of examples.
    var dir = dataDirectories[exampleGroup]["dir"];
    var fetchFunc = dataDirectories[exampleGroup]["fetchFunc"];
    // list all files in the directory
    fs.readdir(dir, (err, files) => {
        if (err) {
            throw err;
        }
        files.forEach(file => {
            try {
                // Load the data.
                const data = yaml.safeLoad(fs.readFileSync(dir + file, 'utf8'));
                // Get the files.
                fetchFunc(data)
            } catch (e) {
                console.log(e);
            }
        });
    });
}

// Main run function.
function run(){
    for ( exampleGroup in dataDirectories ){
        fetch(exampleGroup)
    }
}

// Run it.
run()
