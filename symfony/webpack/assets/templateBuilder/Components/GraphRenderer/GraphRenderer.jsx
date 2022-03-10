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
                <div className={'page-break'}
                    //className={`${idx > 0 && 'page-break'}`}
                >
                    {graph?.details?.title && <h1>{graph.details.title}</h1>}
                    {_renderGraph(graph)}
                    {graph?.details?.description && <p>{graph.details.description}</p>}
                </div>
            )}
        </>
    )
};
