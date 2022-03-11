import React, { useEffect, useState} from 'react';
import { ResponsiveContainer, BarChart, Bar, XAxis, YAxis } from "recharts";

export default function BarGraph({data}){
  
    return(
        <div style={{ width: '500px'}}>
        <ResponsiveContainer height='100%' width='100%' aspect={1/0.5}>
            <BarChart width={500} height={300} data={data}>
            <XAxis dataKey="name" />
            <YAxis dataKey="values" />
            <Bar dataKey="values" />)
            </BarChart>
        </ResponsiveContainer>
      </div>
    )
};
