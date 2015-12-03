<?php

/**
 * 2.56	Planned Procedure Section (V2)
 *
 * This section contains the procedure(s) that a clinician planned based on the preoperative assessment.
 *
 * Contains:
 * Planned Procedure (V2)
 *
 */

namespace LevelSection;

use LevelEntry;
use Exception;

class plannedProcedure
{

    /**
     * @param $Data
     */
    private static function Validate($Data)
    {

    }

    /**
     * Build the Narrative part of this section
     * @param $Data
     */
    public static function Narrative($Data)
    {

    }

    /**
     * @return array
     */
    public static function Structure()
    {
        return [
            'PlannedProcedure' => [

            ]
        ];
    }

    /**
     * @param $PortionData
     * @param $CompleteData
     * @return array|Exception
     */
    public static function Insert($PortionData, $CompleteData)
    {
        try
        {
            // Validate first
            self::Validate($PortionData);

            $Section = [
                'component' => [
                    'section' => [
                        'templateId' => [
                            '@attributes' => [
                                'root' => '2.16.840.1.113883.10.20.22.2.30.2',
                                'extension' => $PortionData['PlannedProcedure']['date']
                            ]
                        ],
                        'code' => [
                            '@attributes' => [
                                'code' => '59772-4',
                                'codeSystem' => '2.16.840.1.113883.6.1',
                                'codeSystemName' => 'LOINC',
                                'displayName' => 'Planned Procedure'
                            ]
                        ],
                        'title' => 'Planned Procedure',
                        'text' => self::Narrative($PortionData['PlannedProcedure'])
                    ]
                ]
            ];

            // Planned Procedure (V2) [0..*]
            foreach($PortionData['PlannedProcedure']['PlannedProcedures'] as $PlannedProcedure) {
                $Section['component']['section']['entry'][] = [
                    'procedure' => LevelEntry\plannedProcedure::Insert($PlannedProcedure, $CompleteData)
                ];
            }

            return $Section;
        }
        catch (Exception $Error)
        {
            return $Error;
        }
    }

}
