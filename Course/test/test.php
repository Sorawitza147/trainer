<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Course</title>
<style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
}

h1 {
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
}

button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}
.back-button {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    text-transform: uppercase;
    font-weight: bold;
    background-color: #00CCFF;
    color: #fff;
}

.back-button:hover {
    background-color: #999;
}
</style>
</head>
<body>
<div class="container">
    <h1>Create Your Course</h1>
    <a href='../indexuser.php' class='back-button'>ย้อนกลับ</a>
    <form action="process_course.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Course Name:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" min="0" step="any" required>
        </div>
        <div class="form-group">
            <label for="duration">Duration (in weeks):</label>
            <input type="number" id="duration" name="duration" min="1" required>
        </div>
        <div class="form-group">
        <label for="difficulty">Difficulty:</label>
        <select id="difficulty" name="difficulty" required>
            <option value="very_easy">Very Easy</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
            <option value="very_hard">Very Hard</option>
        </select>
          </div>
    <<h2>Tag Suggestions</h2>
        <input type="text" id="tagInput" oninput="showSuggestions()">
        <div id="suggestions"></div>
        <h2>Selected Tags</h2>
        <div id="selectedTags"></div>
        <div class="form-group">
            <label for="cover_image">Cover Image:</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" required>
        </div>
        <button type="submit">Create Course</button>
    </form>
</div>
<script>
    // สร้างแผนที่ค่า (map) เพื่อเก็บข้อมูลแท็กและการเรียกใช้ฟังก์ชัน
    const tagSuggestions = new Map([
        ['p', 'PersonalTraining'],
        ['g', 'GroupTraining'],
        ['o', 'OnlineTraining'],
        ['s', 'StrengthTraining'],
        ['c', 'CardioTraining'],
        ['f', 'FlexibilityTraining'],
        ['e', 'EnduranceTraining'],
        ['w', 'WeightLoss'],
        ['m', 'MuscleBuilding'],
        ['t', 'FunctionalTraining'],
        ['ge', 'GymEquipment'],
        ['b', 'BodyweightTraining'],
        ['rb', 'ResistanceBandTraining'],
        ['h', 'HighIntensityIntervalTraining (HIIT)'],
        ['y', 'Yoga'],
        ['pil', 'Pilates'],
        ['n', 'NutritionCoaching'],
        ['mind', 'Mindfulness'],
        ['stress', 'StressManagement'],
        ['cert', 'CertifiedTrainer'],
        ['exp', 'ExperiencedTrainer'],
        ['b', 'BeginnerTraining'],
        ['a', 'AdvancedTraining'],
        ['i', 'IntermediateTraining'],
        ['w', 'WomenFitness'],
        ['m', 'MenFitness'],
        ['t', 'TeenFitness'],
        ['s', 'SeniorFitness'],
        ['s', 'StrengthandConditioning'],
        ['f', 'FitnessAssessment'],
        ['n', 'NutritionalGuidance'],
        ['i', 'InjuryRehabilitation'],
        ['w', 'WeightManagement'],
        ['l', 'LifestyleCoaching'],
        ['c', 'CrossFitTraining'],
        ['t', 'TaiChi'],
        ['k', 'Kickboxing'],
        ['s', 'SelfDefense'],
        ['d', 'DanceFitness'],
        ['p', 'PrenatalFitness'],
        ['p', 'PostnatalFitness'],
        ['a', 'AthleticTraining'],
        ['m', 'MartialArts'],
        ['c', 'CircuitTraining'],
        ['p', 'Powerlifting'],
        ['b', 'BootcampWorkouts'],
        ['r', 'Rehabilitation'],
        ['w', 'WellnessCoaching'],
        ['s', 'SportsPerformance'],
        ['r', 'RunningTraining'],
        ['t', 'TennisTraining'],
        ['g', 'GolfInstruction'],
        ['s', 'SwimmingLessons'],
        ['c', 'CyclingClasses'],
        ['h', 'HikingGuides'],
        ['r', 'RockClimbing'],
        ['b', 'BasketballTraining'],
        ['v', 'VolleyballSkills'],
        ['f', 'FootballCoaching'],
        ['s', 'SoccerSkills'],
        ['a', 'BaseballDrills'],
        ['s', 'SoftballPractice'],
        ['l', 'LacrosseTraining'],
        ['h', 'HockeySkills'],
        ['f', 'FencingLessons'],
        ['e', 'EquestrianTraining'],
        ['s', 'SkiInstruction'],
        ['s', 'SnowboardingLessons'],
        ['i', 'IceSkatingLessons'],
        ['s', 'SurfingLessons'],
        ['p', 'Paddleboarding'],
        ['k', 'KayakingLessons'],
        ['c', 'CanoeingInstruction'],
        ['s', 'SailingLessons'],
        ['r', 'RowingTraining'],
        ['a', 'ArcheryLessons'],
        ['s', 'ShootingInstruction'],
        ['a', 'AerobicsClasses'],
        ['z', 'ZumbaFitness'],
        ['b', 'BarreWorkouts'],
        ['h', 'HulaHoopClasses'],
        ['p', 'PoleDancing'],
        ['s', 'StripTeaseWorkshops'],
        ['b', 'BellyDancingClasses'],
        ['f', 'FlamencoLessons'],
        ['s', 'SalsaDancing'],
        ['b', 'BallroomDance'],
        ['t', 'TapDanceLessons'],
        ['j', 'JazzDance'],
        ['m', 'ModernDance'],
        ['h', 'HipHopDance'],
        ['b', 'Breakdancing'],
        ['t', 'TangoInstruction'],
        ['s', 'SwingDanceClasses'],
        ['l', 'LineDancing'],
        ['c', 'CountryWesternDance'],
        ['s', 'SquareDancing'],
        ['f', 'FolkDanceClasses'],
        ['b', 'BollywoodDance'],
        ['s', 'StreetDance'],
        ['b', 'BalletClasses'],
        ['m', 'MindBodyWorkout'],
        ['a', 'AquaAerobics'],
        ['p', 'ParkourTraining'],
        ['c', 'CapoeiraLessons'],
        ['k', 'KravMaga'],
        ['g', 'GymnasticsTraining'],
        ['a', 'Acrobatics'],
        ['r', 'RhythmicGymnastics'],
        ['t', 'TrampolineWorkouts'],
        ['a', 'AerialSilks'],
        ['a', 'AerialYoga'],
        ['p', 'Piloxing'],
        ['j', 'JiuJitsuClasses'],
        ['k', 'KarateLessons'],
        ['t', 'TaeKwonDo'],
        ['t', 'TraditionalMartialArts'],
        ['w', 'WushuTraining'],
        ['a', 'AikidoLessons'],
        ['c', 'ChoiKwangDo'],
        ['j', 'JapaneseJiuJitsu'],
        ['m', 'MuayThai'],
        ['k', 'KendoInstruction'],
        ['e', 'EscrimaLessons'],
        ['k', 'KaliTraining'],
        ['b', 'Bujinkan'],
        ['c', 'CombatTraining'],
        ['s', 'Systema'],
        ['a', 'Arnis'],
        ['j', 'JeetKuneDo'],
        ['k', 'Kapap'],
        ['s', 'Savate'],
        ['b', 'BrazilianJiuJitsu'],
        ['m', 'MixedMartialArts'],
        ['k', 'KravMaga'],
        ['s', 'SubmissionWrestling'],
        ['c', 'CatchWrestling'],
        ['g', 'GrecoRomanWrestling'],
    ['s', 'SamboTraining'],
    ['l', 'LutaLivre'],
    ['p', 'Pankration'],
    ['m', 'MMAFitness'],
    ['t', 'TacticalTraining'],
    ['s', 'SurvivalSkills'],
    ['u', 'UrbanSurvival'],
    ['w', 'WildernessSurvival'],
    ['e', 'EmergencyPreparedness'],
    ['f', 'FirstAidTraining'],
    ['c', 'CPRCertification'],
    ['a', 'AEDTraining'],
    ['f', 'FirearmsTraining'],
    ['h', 'HuntingSkills'],
    ['f', 'FishingLessons'],
    ['a', 'ArcheryClasses'],
    ['k', 'KnifeThrowing'],
    ['c', 'CampingSkills'],
    ['b', 'Bushcraft'],
    ['o', 'Orienteering'],
    ['m', 'MapandCompass'],
    ['s', 'ScoutSkills'],
    ['k', 'KnotTying'],
    ['b', 'BasicSurvival'],
    ['a', 'AdvancedSurvival'],
    ['w', 'WildEdibles'],
    ['p', 'PrimitiveSurvival'],
    ['t', 'Tracking'],
    ['s', 'ShelterBuilding'],
    ['f', 'ForagingClasses'],
    ['s', 'SurvivalFitness'],
    ['h', 'HerbalMedicine'],
    ['m', 'MedicinalPlants'],
    ['h', 'Herbalism'],
    ['a', 'Ayurveda'],
    ['c', 'ChineseMedicine'],
    ['a', 'AlternativeMedicine'],
    ['h', 'HolisticHealth'],
    ['a', 'Acupuncture'],
    ['h', 'HerbalRemedies'],
    ['a', 'Aromatherapy'],
    ['m', 'MassageTherapy'],
    ['r', 'ReikiHealing'],
    ['h', 'Homeopathy'],
    ['n', 'Naturopathy'],
    ['c', 'ChiropracticCare'],
    ['t', 'TraditionalChineseMedicine'],
    ['t', 'ThaiMassage'],
    ['s', 'ShiatsuMassage'],
    ['t', 'TuiNa'],
    ['c', 'CraniosacralTherapy'],
    ['r', 'Reflexology'],
    ['y', 'YogaTherapy'],
    ['a', 'AyurvedicTherapy'],
    ['m', 'MindfulnessMeditation'],
    ['t', 'TranscendentalMeditation'],
    ['v', 'VipassanaMeditation'],
    ['l', 'LovingKindnessMeditation'],
    ['w', 'WalkingMeditation'],
    ['s', 'SittingMeditation'],
    ['b', 'BodyScanMeditation'],
    ['b', 'BreathAwarenessMeditation'],
    ['g', 'GuidedMeditation'],
    ['m', 'MantraMeditation'],
    ['p', 'Pranayama'],
    ['c', 'ChakraMeditation'],
    ['q', 'QiGong'],
    ['z', 'ZenMeditation'],
    ['c', 'ChristianMeditation'],
    ['i', 'IslamicMeditation'],
    ['j', 'JewishMeditation'],
    ['t', 'TaoistMeditation'],
    ['k', 'KundaliniMeditation'],
    ['t', 'TonglenMeditation'],
    ['s', 'SufiMeditation'],
    ['s', 'SoundHealing'],
    ['c', 'CrystalHealing'],
    ['r', 'ReikiTherapy'],
    ['p', 'PranicHealing'],
    ['q', 'QuantumHealing'],
    ['a', 'AuraCleansing'],
    ['a', 'AngelTherapy'],
    ['a', 'AnimalReiki'],
    ['c', 'ColorTherapy'],
    ['m', 'MusicTherapy'],
    ['d', 'DanceTherapy'],
    ['a', 'ArtTherapy'],
    ['t', 'TherapeuticTouch'],
    ['h', 'Hypnotherapy'],
    ['s', 'SomaticTherapy'],
    ['e', 'EMDRTherapy'],
    ['b', 'BiofeedbackTherapy'],
    ['r', 'RegressionTherapy'],
    ['n', 'NeurofeedbackTherapy'],
    ['p', 'Psychotherapy'],
    ['c', 'CognitiveBehavioralTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['m', 'MotivationalInterviewing'],
    ['f', 'FamilyTherapy'],
    ['m', 'MarriageCounseling'],
    ['a', 'AddictionCounseling'],
    ['g', 'GriefCounseling'],
    ['t', 'TraumaTherapy'],
    ['p', 'PTSDTherapy'],
    ['a', 'ArtTherapy'],
    ['m', 'MusicTherapy'],
    ['d', 'DramaTherapy'],
    ['e', 'ExpressiveArtsTherapy'],
    ['e', 'EcoTherapy'],
    ['w', 'WildernessTherapy'],
    ['h', 'HorticulturalTherapy'],
    ['a', 'AdventureTherapy'],
    ['e', 'EquineTherapy'],
    ['s', 'SandplayTherapy'],
    ['p', 'PlayTherapy'],
    ['p', 'PetTherapy'],
    ['r', 'RecreationalTherapy'],
    ['l', 'LaughterTherapy'],
    ['h', 'HappinessTherapy'],
    ['m', 'MindfulnessBasedCognitiveTherapy'],
    ['m', 'MindfulnessBasedStressReduction'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['m', 'MindfulnessBasedRelapsePrevention'],
    ['a', 'AcceptanceandCommitmentTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['e', 'EmotionFocusedTherapy'],
    ['i', 'InternalFamilySystems'],
    ['n', 'NarrativeTherapy'],
    ['s', 'SolutionFocusedTherapy'],
    ['c', 'CognitiveTherapy'],
    ['g', 'GestaltTherapy'],
    ['p', 'Psychoanalysis'],
    ['j', 'JungianAnalysis'],
    ['r', 'RealityTherapy'],
    ['t', 'TransactionalAnalysis'],
    ['f', 'FeministTherapy'],
    ['m', 'MulticulturalTherapy'],
    ['e', 'ExistentialTherapy'],
    ['h', 'HumanisticTherapy'],
    ['l', 'Logotherapy'],
    ['t', 'TranspersonalTherapy'],
    ['i', 'IntegrativeTherapy'],
    ['s', 'SystemicTherapy'],
    ['s', 'StrengthBasedTherapy'],
    ['c', 'ClientCenteredTherapy'],
    ['e', 'EclecticTherlecticTherapy'],
    ['h', 'HolisticTherapy'],
    ['i', 'IntuitiveTherapy'],
    ['t', 'TherapeuticCounseling'],
    ['r', 'RehabilitativeTherapy'],
    ['s', 'SubstanceAbuseCounseling'],
    ['d', 'DepressionTherapy'],
    ['a', 'AnxietyTherapy'],
    ['a', 'AngerManagement'],
    ['b', 'BipolarDisorderTreatment'],
    ['o', 'ObsessiveCompulsiveDisorderTherapy'],
    ['s', 'StressCounseling'],
    ['g', 'GriefTherapy'],
    ['p', 'PostTraumaticStressDisorderTherapy'],
    ['a', 'AddictionRecovery'],
    ['s', 'SelfEsteemTherapy'],
    ['r', 'RelationshipCounseling'],
    ['m', 'MarriageTherapy'],
    ['p', 'PremaritalCounseling'],
    ['d', 'DivorceRecovery'],
    ['c', 'ChildTherapy'],
    ['a', 'AdolescentCounseling'],
    ['f', 'FamilyCounseling'],
    ['p', 'ParentingClasses'],
    ['s', 'SexTherapy'],
    ['l', 'LGBTQTherapy'],
    ['c', 'CouplesCounseling'],
    ['t', 'TeenTherapy'],
    ['p', 'PlayTherapy'],
    ['s', 'SandplayTherapy'],
    ['m', 'MusicTherapy'],
    ['d', 'DramaTherapy'],
    ['e', 'ExpressiveArtsTherapy'],
    ['a', 'ArtTherapy'],
    ['p', 'Psychotherapy'],
    ['c', 'CognitiveBehavioralTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['m', 'MindfulnessBasedCognitiveTherapy'],
    ['e', 'ExposureTherapy'],
    ['n', 'NarrativeTherapy'],
    ['f', 'FamilyTherapy'],
    ['g', 'GroupTherapy'],
    ['i', 'IndividualTherapy'],
    ['c', 'ChildPsychology'],
    ['a', 'AdolescentPsychology'],
    ['d', 'DevelopmentalPsychology'],
    ['s', 'SocialPsychology'],
    ['c', 'CognitivePsychology'],
    ['a', 'AbnormalPsychology'],
    ['f', 'ForensicPsychology'],
    ['h', 'HealthPsychology'],
    ['o', 'OrganizationalPsychology'],
    ['e', 'EducationalPsychology'],
    ['s', 'SportsPsychology'],
    ['c', 'ClinicalPsychology'],
    ['c', 'CounselingPsychology'],
    ['i', 'IndustrialPsychology'],
    ['m', 'MilitaryPsychology'],
    ['p', 'PoliticalPsychology'],
    ['t', 'TrafficPsychology'],
    ['e', 'EnvironmentalPsychology'],
    ['c', 'ConsumerPsychology'],
    ['r', 'ReligionPsychology'],
    ['f', 'PositivePsychology'],
    ['m', 'MulticulturalPsychology'],
    ['a', 'AppliedPsychology'],
    ['e', 'EvolutionaryPsychology'],
    ['p', 'PsychodynamicTherapy'],
    ['a', 'AnalyticalPsychology'],
    ['g', 'GestaltTherapy'],
    ['r', 'RealityTherapy'],
    ['t', 'TransactionalAnalysis'],
    ['e', 'ExistentialTherapy'],
    ['h', 'HumanisticTherapy'],
    ['l', 'Logotherapy'],
    ['t', 'TranspersonalTherapy'],
    ['c', 'CognitiveTherapy'],
    ['b', 'BehavioralTherapy'],
    ['s', 'SolutionFocusedTherapy'],
    ['i', 'IntegrativeTherapy'],
    ['p', 'Psychoanalysis'],
    ['j', 'JungianAnalysis'],
    ['f', 'FamilyTherapy'],
    ['m', 'MarriageCounseling'],
    ['a', 'ArtTherapy'],
    ['d', 'DramaTherapy'],
    ['m', 'MusicTherapy'],
    ['e', 'ExpressiveArtsTherapy'],
    ['p', 'PlayTherapy'],
    ['s', 'SandplayTherapy'],
    ['b', 'BehaviorTherapy'],
    ['c', 'CognitiveBehavioralTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['a', 'AcceptanceandCommitmentTherapy'],
    ['m', 'MindfulnessBasedCognitiveTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['e', 'EmotionFocusedTherapy'],
    ['e', 'ExistentialTherapy'],
    ['s', 'SchemaTherapy'],
    ['p', 'PsychoanalyticTherapy'],
    ['c', 'ClientCenteredTherapy'],
    ['n', 'NarrativeTherapy'],
    ['i', 'InterpersonalTherapy'],
    ['s', 'SystemicTherapy'],
    ['m', 'MultimodalTherapy'],
    ['i', 'IntegrativeTherapy'],
    ['p', 'PersonCenteredTherapy'],
    ['g', 'GestaltTherapy'],
    ['a', 'AnalyticalPsychotherapy'],
    ['r', 'RealityTherapy'],
    ['t', 'TransactionalAnalysis'],
    ['e', 'ExistentialTherapy'],
    ['h', 'HumanisticTherapy'],
    ['l', 'Logotherapy'],
    ['t', 'TranspersonalTherapy'],
    ['c', 'CognitiveTherapy'],
    ['b', 'BehavioralTherapy'],
    ['s', 'SolutionFocusedTherapy'],
    ['i', 'IntegrativeTherapy'],
    ['p', 'Psychoanalysis'],
    ['j', 'JungianAnalysis'],
    ['f', 'FamilyTherapy'],
    ['m', 'MarriageCounseling'],
    ['a', 'ArtTherapy'],
    ['d', 'DramaTherapy'],
    ['m', 'MusicTherapy'],
    ['e', 'ExpressiveArtsTherapy'],
    ['p', 'PlayTherapy'],
    ['s', 'SandplayTherapy'],
    ['c', 'CognitiveBehavioralTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['m', 'MindfulnessBasedCognitiveTherapy'],
    ['e', 'ExposureTherapy'],
    ['n', 'NarrativeTherapy'],
    ['f', 'FamilyTherapy'],
    ['g', 'GroupTherapy'],
    ['i', 'IndividualTherapy'],
    ['c', 'ChildPsychology'],
    ['a', 'AdolescentPsychology'],
    ['d', 'DevelopmentalPsychology'],
    ['s', 'SocialPsychology'],
    ['c', 'CognitivePsychology'],
    ['a', 'AdolescentPsychology'],
    ['d', 'DevelopmentalPsychology'],
    ['s', 'SocialPsychology'],
    ['c', 'CognitivePsychology'],
    ['a', 'AbnormalPsychology'],
    ['f', 'ForensicPsychology'],
    ['h', 'HealthPsychology'],
    ['o', 'OrganizationalPsychology'],
    ['e', 'EducationalPsychology'],
    ['s', 'SportsPsychology'],
    ['c', 'ClinicalPsychology'],
    ['c', 'CounselingPsychology'],
    ['i', 'IndustrialPsychology'],
    ['m', 'MilitaryPsychology'],
    ['p', 'PoliticalPsychology'],
    ['t', 'TrafficPsychology'],
    ['e', 'EnvironmentalPsychology'],
    ['c', 'ConsumerPsychology'],
    ['r', 'ReligionPsychology'],
    ['f', 'PositivePsychology'],
    ['m', 'MulticulturalPsychology'],
    ['a', 'AppliedPsychology'],
    ['e', 'EvolutionaryPsychology'],
    ['p', 'PsychodynamicTherapy'],
    ['a', 'AnalyticalPsychology'],
    ['g', 'GestaltTherapy'],
    ['r', 'RealityTherapy'],
    ['t', 'TransactionalAnalysis'],
    ['e', 'ExistentialTherapy'],
    ['h', 'HumanisticTherapy'],
    ['l', 'Logotherapy'],
    ['t', 'TranspersonalTherapy'],
    ['c', 'CognitiveTherapy'],
    ['b', 'BehavioralTherapy'],
    ['s', 'SolutionFocusedTherapy'],
    ['i', 'IntegrativeTherapy'],
    ['p', 'Psychoanalysis'],
    ['j', 'JungianAnalysis'],
    ['f', 'FamilyTherapy'],
    ['m', 'MarriageCounseling'],
    ['a', 'ArtTherapy'],
    ['d', 'DramaTherapy'],
    ['m', 'MusicTherapy'],
    ['e', 'ExpressiveArtsTherapy'],
    ['p', 'PlayTherapy'],
    ['s', 'SandplayTherapy'],
    ['b', 'BehaviorTherapy'],
    ['c', 'CognitiveBehavioralTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['a', 'AcceptanceandCommitmentTherapy'],
    ['m', 'MindfulnessBasedCognitiveTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['e', 'EmotionFocusedTherapy'],
    ['e', 'ExistentialTherapy'],
    ['s', 'SchemaTherapy'],
    ['p', 'PsychoanalyticTherapy'],
    ['c', 'ClientCenteredTherapy'],
    ['n', 'NarrativeTherapy'],
    ['i', 'InterpersonalTherapy'],
    ['s', 'SystemicTherapy'],
    ['m', 'MultimodalTherapy'],
    ['i', 'IntegrativeTherapy'],
    ['p', 'PersonCenteredTherapy'],
    ['g', 'GestaltTherapy'],
    ['a', 'AnalyticalPsychotherapy'],
    ['r', 'RealityTherapy'],
    ['t', 'TransactionalAnalysis'],
    ['e', 'ExistentialTherapy'],
    ['h', 'HumanisticTherapy'],
    ['l', 'Logotherapy'],
    ['t', 'TranspersonalTherapy'],
    ['c', 'CognitiveTherapy'],
    ['b', 'BehavioralTherapy'],
    ['s', 'SolutionFocusedTherapy'],
    ['i', 'IntegrativeTherapy'],
    ['p', 'Psychoanalysis'],
    ['j', 'JungianAnalysis'],
    ['f', 'FamilyTherapy'],
    ['m', 'MarriageCounseling'],
    ['a', 'ArtTherapy'],
    ['d', 'DramaTherapy'],
    ['m', 'MusicTherapy'],
    ['e', 'ExpressiveArtsTherapy'],
    ['p', 'PlayTherapy'],
    ['s', 'SandplayTherapy'],
    ['c', 'CognitiveBehavioralTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],
    ['m', 'MindfulnessBasedCognitiveTherapy'],
    ['e', 'ExposureTherapy'],
    ['n', 'NarrativeTherapy'],
    ['f', 'FamilyTherapy'],
    ['g', 'GroupTherapy'],
    ['i', 'IndividualTherapy'],
    ['c', 'ChildPsychology'],
    ['a', 'AdolescentPsychology'],
    ['d', 'DevelopmentalPsychology'],
    ['s', 'SocialPsychology'],
    ['c', 'CognitivePsychology'],
    ['a', 'AbnormalPsychology'],
    ['f', 'ForensicPsychology'],
    ['h', 'HealthPsychology'],
    ['o', 'OrganizationalPsychology'],
    ['e', 'EducationalPsychology'],
    ['s', 'SportsPsychology'],
    ['c', 'ClinicalPsychology'],
    ['c', 'CounselingPsychology'],
    ['i', 'IndustrialPsychology'],
    ['m', 'MilitaryPsychology'],
    ['p', 'PoliticalPsychology'],
    ['t', 'TrafficPsychology'],
    ['e', 'EnvironmentalPsychology'],
    ['c', 'ConsumerPsychology'],
    ['r', 'ReligionPsychology'],
    ['f', 'PositivePsychology'],
    ['m', 'MulticulturalPsychology'],
    ['a', 'AppliedPsychology'],
    ['e', 'EvolutionaryPsychology'],
    ['p', 'PsychodynamicTherapy'],
    ['a', 'AnalyticalPsychology'],
    ['g', 'GestaltTherapy'],
    ['r', 'RealityTherapy'],
    ['t', 'TransactionalAnalysis'],
    ['e', 'ExistentialTherapy'],
    ['h', 'HumanisticTherapy'],
    ['l', 'Logotherapy'],
    ['t', 'TranspersonalTherapy'],
    ['c', 'CognitiveTherapy'],
    ['b', 'BehavioralTherapy'],
    ['s', 'SolutionFocusedTherapy'],
    ['i', 'IntegrativeTherapy'],
    ['p', 'Psychoanalysis'],
    ['j', 'JungianAnalysis'],
    ['f', 'FamilyTherapy'],
    ['m', 'MarriageCounseling'],
    ['a', 'ArtTherapy'],
    ['d', 'DramaTherapy'],
    ['m', 'MusicTherapy'],
    ['e', 'ExpressiveArtsTherapy'],
    ['p', 'PlayTherapy'],
    ['s', 'SandplayTherapy'],
    ['c', 'CognitiveBehavioralTherapy'],
    ['d', 'DialecticalBehavioralTherapy'],  
    ['m', 'MindfulnessBasedCognitiveTherapy'],
    ['e', 'ExposureTherapy'],
    ['n', 'NarrativeTherapy'],
    ['f', 'FamilyTherapy'],
    ]);

    const selectedTags = new Set();

function showSuggestions() {
  const input = document.getElementById('tagInput').value.trim().toLowerCase();
  const suggestionsDiv = document.getElementById('suggestions');
  suggestionsDiv.innerHTML = '';

  // Filter suggestions based on input
  for (const [key, tag] of tagSuggestions) {
    if (key.toLowerCase().includes(input)) {
      const suggestion = document.createElement('div');
      suggestion.classList.add('suggestion');
      suggestion.textContent = `${key} - ${tag}`;
      suggestion.onclick = () => toggleTag(tag);
      suggestionsDiv.appendChild(suggestion);
    }
  }
}

function toggleTag(tag) {
  if (selectedTags.has(tag)) {
    selectedTags.delete(tag);
  } else {
    selectedTags.add(tag);
  }

  renderSelectedTags();
}

function renderSelectedTags() {
  const selectedTagsDiv = document.getElementById('selectedTags');
  selectedTagsDiv.innerHTML = '';

  selectedTags.forEach(tag => {
    const tagElement = document.createElement('div');
    tagElement.textContent = tag;
    selectedTagsDiv.appendChild(tagElement);
  });
}
</script>
</body>
</html>
