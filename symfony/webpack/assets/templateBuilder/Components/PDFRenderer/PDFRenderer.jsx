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
            <h3 style={{textAlign: 'center'}}>THE FILE HAS BEEN CREATED</h3>
            <div style={{display: 'flex', justifyContent: 'center'}}>
                <button
                    style={{display: 'flex', alignItems: 'center'}}
                    className='report-maker-btn'
                    onClick={handleExportWithComponent}>
                    <span style={{marginRight: '5px'}}>EXPORT</span>
                    <svg width="14" height="14" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_132_602)">
                        <path d="M7.85547 13.4897L7.85547 0.293917" stroke="#FCF8F3" stroke-miterlimit="10"/>
                        <path d="M12.1758 4.58936C11.206 4.15733 10.3255 3.52137 9.5855 2.71848C8.85891 1.95016 8.29231 1.02345 7.92346 7.49004e-05L7.86756 7.4895e-05C7.49985 1.02408 6.93311 1.95104 6.20552 2.71848C5.46613 3.52098 4.58649 4.15691 3.61768 4.58935" stroke="#FCF8F3" stroke-miterlimit="10"/>
                        <path d="M15.6724 12.3091V15.1954C15.6724 16.1697 15.314 17.1041 14.676 17.793C14.0381 18.4819 13.1728 18.869 12.2706 18.869H3.52295C2.62072 18.869 1.75545 18.4819 1.11748 17.793C0.479507 17.1041 0.121094 16.1697 0.121094 15.1954V12.3091" stroke="#FCF8F3" stroke-miterlimit="10"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_132_602">
                        <rect width="15.7943" height="19" fill="white"/>
                        </clipPath>
                        </defs>
                    </svg>
                </button>
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