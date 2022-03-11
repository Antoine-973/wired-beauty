import React, { useState, useEffect} from 'react';
import BarGraph from '../Graphics/BarGraph/BarGraph';
import LineGraph from '../Graphics/LineGraph/LineGraph';
export default function GraphRenderer({graphData = []}){

    const _renderGraph = graph => {
        if(graph.type === 'bar'){
            return(
                <BarGraph data={graph.data}/>
            )
        }
        
        if(graph.type === 'line'){
            return <LineGraph data={graph.data}/>
        }
    };

    return(
        <>
            {graphData.length > 0 && 
            graphData.map( (graph, idx) =>
                <div className={'page-break pdf-page'}
                    //className={`${idx > 0 && 'page-break'}`}
                >
                    {graph?.details?.title && <h3 style={{fontSize: '22px', fontWeight: 'bolder', textAlign: 'center', width: '100%', marginTop: '10px'}}>{graph.details.title}</h3>}
                    {
                        graph?.details?.description && 
                        <p style={{ textAlign: 'justify', width: '100%'}}>{graph.details.description}</p>
                    }
                    {_renderGraph(graph)}
                </div>
            )}
        </>
    )
};
