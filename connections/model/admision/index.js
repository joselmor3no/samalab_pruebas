const fs = require('fs'),
        PDFParser = require("pdf2json");

    const pdfParser = new PDFParser();

    pdfParser.on("pdfParser_dataError", errData => console.error(errData.parserError) );
    pdfParser.on("pdfParser_dataReady", pdfData => {
        fs.writeFile("ejemplo.json", JSON.stringify(pdfData));
    });

    pdfParser.loadPDF("cfs.pdf");