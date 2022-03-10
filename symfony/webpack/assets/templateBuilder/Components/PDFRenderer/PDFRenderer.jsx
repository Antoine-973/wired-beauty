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

export default function PDFRenderer({studyDetails, children}){
    const pdfExportComponent = useRef(null);
    //const contentArea = useRef(null);
    
    const handleExportWithComponent = (event) => {
      pdfExportComponent.current.save();
    }
  
    // const handleExportWithFunction = (event) => {
    //   savePDF(contentArea.current, { paperSize: "A4" });
    // }

    return(
        <div>
            <div className="button-area">
                <button primary={true} onClick={handleExportWithComponent}>Export</button>
                {/* <button onClick={handleExportWithFunction}>Export with Method</button> */}
            </div>
            <div
                style={{
                    position: "absolute",
                    left: "-1000px",
                    top: 0,
                }}
            >
                <PDFExport
                    pageTemplate={PageTemplate}
                    paperSize="A4"
                    margin="2cm"
                    forcePageBreak=".page-break"
                    ref={pdfExportComponent}
                    title={studyDetails?.title??'no_name_study'}
                    fileName={studyDetails?.title ? studyDetails.title.split(' ').join('_'): 'no_name_study'}
                >
                    <div /*ref={contentArea}*/>
                        <div style={{height: '742px', width: '470px', display: 'flex', flexDirection: 'column', justifyContent: 'center'}}>
                            <h1 style={{fontSize: '44px', textAlign: 'center', width: '100%', marginTop: '-130px'}}>{studyDetails?.title}</h1>
                        </div>
                        <p 
                            style={{ marginTop: '100px'}}
                            className='page-break'>{studyDetails?.subTitle}</p>
                        {children}
                    </div>
                </PDFExport>
            </div>
        </div>
    )
}