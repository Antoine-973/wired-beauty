import React from 'react';
import { PDFExport, savePDF } from '@progress/kendo-react-pdf';
import { useRef } from 'react';
import Logo from '../../assets/images/logo-v2.png';
import './PDF.scss';
import moment from 'moment';

export default function PDFRenderer({studyDetails, children}){
    const pdfExportComponent = useRef(null);
    //const contentArea = useRef(null);
    
    const handleExportWithComponent = (event) => {
      pdfExportComponent.current.save();
    }
  
    // const handleExportWithFunction = (event) => {
    //   savePDF(contentArea.current, { paperSize: "A4" });
    // }


    const PageTemplate = props => {
        return (
            <>
                {props.pageNum > 1 &&
                <div style={{width: '100%', position: 'absolute', left: 0, top: '10px', display: 'flex', flexDirection: 'row', justifyContent: 'center', justifyItems: 'center'}}>
                    <img
                        style={{height: '30px'}} 
                        src={Logo}/>
                </div>
                }
                <div className='template-pdf'
                    style={{position: 'absolute', bottom: '10px', fontSize:'13px', left: '50%', transform: 'translateX(-50%)', display: 'flex', alignItems: 'center' }}>
                        <p style={{ fontSize: '10px', fontWeight: 'lighter' }}>
                            {props.pageNum}
                        </p>
                        <p style={{padding: '0px 5px'}}>|</p>
                        <p style={{ fontSize: '10px', fontFamily: 'Montserrat", sans-serif', color: '#082C36', textTransform: 'uppercase' }}>
                            {studyDetails?.title}
                        </p>
                </div>
            </>
        );
    };

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
                    <div /*ref={contentArea}*/ className='pdf-content'>
                        <div id="page-1" className='pdf-page'
                            style={{ display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center', position: 'relative'}}>
                            
                            <img src={Logo} style={{width: '130px'}} />
                            <h1 style={{fontSize: '33px', fontWeight: 'bolder', width: '100%', textAlign: 'center', padding: 0, marginTop: '50px'}}>{studyDetails?.title}</h1>
                            <p>{moment().format('YYYY-MM-DD').toString()}</p>
                           
                            <svg style={{position: 'absolute', top: 0, left: 0}}
                                width="112.5" height="138" viewBox="0 0 225 276" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M225 75L152.333 75L116 138L152.333 201" stroke="#13667A"/>
                                <path d="M-2.46331e-06 72.5L36.5 9.71316L109.5 9.71316L146 72.5L109.5 135.287L36.5 135.287L-2.46331e-06 72.5Z" fill="#13667A" fill-opacity="0.25"/>
                                <path d="M36.7867 265.854L0.579365 204L36.7867 142.146L109.213 142.146L145.421 204L109.213 265.854L36.7867 265.854Z" stroke="#13667A"/>
                            </svg>

                            <svg style={{position: 'absolute', top: 0, right: 0}}
                                width="112.5" height="138" viewBox="0 0 225 276" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M-6.85736e-06 75L72.6667 75L109 138L72.6667 201" stroke="#13667A"/>
                                <path d="M225 72.5L188.5 9.71316L115.5 9.71316L79 72.5L115.5 135.287L188.5 135.287L225 72.5Z" fill="#13667A" fill-opacity="0.25"/>
                                <path d="M188.213 265.854L224.421 204L188.213 142.146L115.787 142.146L79.5794 204L115.787 265.854L188.213 265.854Z" stroke="#13667A"/>
                            </svg>


                        </div>
                        {studyDetails?.subTitle && 
                            <div id="page-2" className='pdf-page page-break' >
                                <h3 style={{fontSize: '22px', fontWeight: 'bolder', textAlign: 'center', width: '100%', marginTop: '10px'}}>PREAMBLE</h3>
                                <p style={{ textAlign: 'justify', width: '100%'}}>{studyDetails?.subTitle}</p>
                            </div>
                        }
                        {children}
                    </div>
                </PDFExport>
            </div>
        </div>
    )
}