import React, { useEffect, useState} from 'react';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from "recharts";

const COLORS = [
    '#c96226', '#8884d8', '#3b9bdb', '#72db90'
];

export default function LineGraph({data}){
  
    console.log(data)
    return(
        <div style={{ width: '500px'}}>
         <ResponsiveContainer height='100%' width='100%' aspect={1/0.5}>
            <LineChart margin={{ top: 5, right: 20, bottom: 5, left: 0 }} >
            <XAxis allowDuplicatedCategory={false} dataKey={"name"}/>
            <YAxis allowDuplicatedCategories={false} />
            <CartesianGrid strokeDasharray="3 3"/>
            <Tooltip/>
            <Legend />
            { Object.keys(data).length > 0 &&
                Object.values(data).map( (prod, idx) => 
                <Line
                    key={idx}
                    name={prod[0] && prod[0].filter}
                    data={prod} 
                    type="monotone"
                    dataKey="values"
                    stroke={`${COLORS[idx%COLORS.length]}`}
                    activeDot={{r: 8}}/>
                )
            }
            </LineChart>
        </ResponsiveContainer>
      </div>
    )
};
