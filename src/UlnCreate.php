<?php
namespace EsfaTools;
use Exception;
use InvalidArgumentException;

class UlnCreate
{
    /**
     * @method createTestUln
     * this will generate a test uln acceptable to the ESFA API as per:
     * @link https://github.com/SkillsFundingAgency/das-assessor-service-external-apiclient#monthly-sandbox-ilr-test-data-refresh
     *
     * requires an EPAO org id in the form EPAnnnn where n is a digit from the register of end point assessment organisations
     * @link https://www.gov.uk/guidance/register-of-end-point-assessment-organisations
     *
     * the generated ULN is not necessarily a valid uln and can only be used with the ESFA sandbox
     *
     * @param string $epaoOrgId
     * @param int $larsCode
     * @param int $sequence
     *
     * @return int
     */

    public static function createTestUln (string $epaoOrgId, int $larsCode, int $sequence): int
    {
        if (!preg_match('/EPA\d{4}/i', $epaoOrgId)) {
            throw new InvalidArgumentException("EPAO org id is in the wrong format");
        }
        if ($sequence < 0 || $sequence > 9 ) {
            throw new InvalidArgumentException("sequence must be between 0 and 9");
        }

        $epao_id_part = substr($epaoOrgId, -4, 4);
        $filled_lars = str_pad($larsCode, 3, '0', STR_PAD_LEFT);
        $filled_sequence = str_pad($sequence, 2, '0', STR_PAD_LEFT);

        return intval("1$epao_id_part$filled_lars$filled_sequence");
    }

    /**
     * @method createTestApprentice
     * this will generate up to 10 test apprentices per standard and epao with ULNs in the form
     * acceptable to the ESFA sandbox API as per:
     * @link https://github.com/SkillsFundingAgency/das-assessor-service-external-apiclient#monthly-sandbox-ilr-test-data-refresh
     *
     * The set of ILR records follow this pattern:

     * uln = 10 digits
     * "1" - leading digit
     * "xxxx" - 4 digits of EPAOrgId
     * "xxx" - 3 digits of LARS Standard Code (leading 0s)
     *  "00 - 09" - 10 unique ulns per standard code
     * Example. For EPA0001, Standard Code = 80, and 1st uln in the sequence

     * uln = "1" + "0001" + "080" + "01" = 1000108001
     * givenNames = Test
     * familyName = 1000108001 (same value as uln)
     * standard = 80
     *
     * @param string $epaoOrgId
     * @param int $larsCode
     * @param int $addNumber
     *
     * @return array
     * @throws Exception
     */
    public static function createTestApprentice(string $epaoOrgId, int $larsCode, int $addNumber = 1): array
    {
        if ($addNumber > 10) {
            throw new InvalidArgumentException("maximum of 10 in a sequence per EPAO and LARS code");
        }
        if ($addNumber < 1) {
            throw new InvalidArgumentException("minimum of 1 in a sequence per EPAO and LARS code");
        }

        $testApprentices = array();
        $addedCount = 0;

        for ($i = 0; $i < $addNumber; $i++) {
            $uln = self::createTestUln($epaoOrgId, $larsCode, $i);
            $firstName = 'Test';
            $lastName = $uln;
            $addedCount++;
            $testApprentices[]=array(
                'firstName' => $firstName,
                'lastName'  => $lastName,
                'uln'       => $uln,
            );
        }

        return $testApprentices;
    }
}

