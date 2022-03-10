import React from 'react';
import { PDFExport, savePDF } from '@progress/kendo-react-pdf';
import { useRef } from 'react';
import Logo from '../../assets/images/logo.png';

const PageTemplate = props => {
    return (
        <>
            <p style={{position: 'absolute', left: '10px', bottom: '10px', fontSize:'13px'}}>Page {props.pageNum} of {props.totalPages}</p>
            <img style={{height: '50px', position: 'absolute', right: '10px', bottom: '10px'}} src={Logo}/>
        </>
      );
};

export default function PDFDocument({children}){
    const pdfExportComponent = useRef(null);
    const contentArea = useRef(null);
    
    const handleExportWithComponent = (event) => {
      pdfExportComponent.current.save();
    }
  
    const handleExportWithFunction = (event) => {
      savePDF(contentArea.current, { paperSize: "A4" });
    }

    return(
        <div>
           <div className="button-area">
                <button primary={true} onClick={handleExportWithComponent}>Export</button>
                {/* <button onClick={handleExportWithFunction}>Export with Method</button> */}
            </div>

            <PDFExport
                pageTemplate={PageTemplate}
                paperSize="A4"
                margin="2cm"
                forcePageBreak=".page-break"
                ref={pdfExportComponent}
            >
                <div ref={contentArea}>
                    {children}
                </div>
    
            </PDFExport>
        </div>
    );

}