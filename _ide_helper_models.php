<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Attendance{
/**
 * @property int $idattendance
 * @property int $user_iduser
 * @property int|null $attendance Yes/ No
 * @property int|null $approval
 * @property string|null $date yyyy-mm-dd
 * @property int|null $project_idProject
 * @property-read \App\Models\ProjectManagement\Project|null $project
 * @property-read \App\Models\UserManagement\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereApproval($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereAttendance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereIdattendance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereProjectIdProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereUserIduser($value)
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models\ProjectManagement{
/**
 * @property int $idassign_technician
 * @property int|null $Project_idProject
 * @property int|null $user_iduser
 * @property int|null $status
 * @property-read \App\Models\ProjectManagement\Project|null $project
 * @property-read \App\Models\UserManagement\User|null $technician
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignTechnician newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignTechnician newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignTechnician query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignTechnician whereIdassignTechnician($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignTechnician whereProjectIdProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignTechnician whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignTechnician whereUserIduser($value)
 */
	class AssignTechnician extends \Eloquent {}
}

namespace App\Models\ProjectManagement{
/**
 * @property int $idcancellation
 * @property int|null $Project_idProject
 * @property int $assign_technician_idassign_technician
 * @property string|null $reason
 * @property-read \App\Models\ProjectManagement\AssignTechnician $assignTechnician
 * @property-read \App\Models\ProjectManagement\Project|null $project
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cancellation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cancellation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cancellation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cancellation whereAssignTechnicianIdassignTechnician($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cancellation whereIdcancellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cancellation whereProjectIdProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cancellation whereReason($value)
 */
	class Cancellation extends \Eloquent {}
}

namespace App\Models\ProjectManagement{
/**
 * @property int $idProject
 * @property string|null $customer_name
 * @property int|null $solar_idsolar
 * @property string|null $location
 * @property string|null $contact
 * @property int|null $partner_company_idpartner_company
 * @property int|null $user_iduser
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\SystemSettings\PartnerCompany|null $Partner
 * @property-read \App\Models\SystemSettings\Solar|null $Solar
 * @property-read \App\Models\UserManagement\User|null $User
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectManagement\AssignTechnician> $assignedTechnicians
 * @property-read int|null $assigned_technicians_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectManagement\Cancellation> $cancellations
 * @property-read int|null $cancellations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereIdProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project wherePartnerCompanyIdpartnerCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereSolarIdsolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUserIduser($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models\Proof{
/**
 * @property int $idproof_image
 * @property int $proof_of_work_idproof_of_work
 * @property string $section
 * @property string $image_path
 * @property-read \App\Models\Proof\ProofOfWork $proofOfWork
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofImage whereIdproofImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofImage whereProofOfWorkIdproofOfWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofImage whereSection($value)
 */
	class ProofImage extends \Eloquent {}
}

namespace App\Models\Proof{
/**
 * @property int $idproof_of_work
 * @property int $Project_idProject
 * @property int $user_iduser
 * @property int|null $approval
 * @property int|null $additional_work_idadditional_work
 * @property string|null $section
 * @property string|null $uploaded_at
 * @property-read \App\Models\SystemSettings\AdditionalWork|null $additionalWork
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Proof\ProofImage> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\ProjectManagement\Project $project
 * @property-read \App\Models\UserManagement\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork whereAdditionalWorkIdadditionalWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork whereApproval($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork whereIdproofOfWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork whereProjectIdProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork whereUploadedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProofOfWork whereUserIduser($value)
 */
	class ProofOfWork extends \Eloquent {}
}

namespace App\Models\Proof{
/**
 * @property int $idwork_completion
 * @property int $user_iduser
 * @property int $Project_idProject
 * @property string|null $completion_date
 * @property-read \App\Models\ProjectManagement\Project $project
 * @property-read \App\Models\UserManagement\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCompletion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCompletion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCompletion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCompletion whereCompletionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCompletion whereIdworkCompletion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCompletion whereProjectIdProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkCompletion whereUserIduser($value)
 */
	class WorkCompletion extends \Eloquent {}
}

namespace App\Models\SysLog{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemActivityLog query()
 */
	class SystemActivityLog extends \Eloquent {}
}

namespace App\Models\SysLog{
/**
 * @property int $iduser_activity_logs
 * @property int $user_iduser
 * @property string|null $action_type
 * @property string|null $module
 * @property string|null $record_id
 * @property string|null $action_description
 * @property string|null $old_values
 * @property string|null $new_values
 * @property string|null $ip_address
 * @property string|null $device
 * @property string|null $login_time
 * @property string|null $logout_time
 * @property string|null $session_id
 * @property-read \App\Models\UserManagement\User $User
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereActionDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereIduserActivityLogs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereLogoutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserActivityLog whereUserIduser($value)
 */
	class UserActivityLog extends \Eloquent {}
}

namespace App\Models\SystemBackup{
/**
 * @property int $idbackup_schedule
 * @property string|null $backup_type
 * @property string|null $backup_category
 * @property string|null $frequency
 * @property \Illuminate\Support\Carbon|null $schedule_time
 * @property \Illuminate\Support\Carbon|null $last_run
 * @property \Illuminate\Support\Carbon|null $next_run
 * @property \Illuminate\Support\Carbon|null $retention_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereBackupCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereBackupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereIdbackupSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereLastRun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereNextRun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereRetentionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereScheduleTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSchedule whereUpdatedAt($value)
 */
	class BackupSchedule extends \Eloquent {}
}

namespace App\Models\SystemBackup{
/**
 * @property int $iddata_backups
 * @property string|null $backup_type
 * @property string|null $backup_category
 * @property string|null $backup_date
 * @property string|null $file_path
 * @property int|null $file_size
 * @property int|null $status
 * @property string|null $error_message
 * @property string|null $completion_time
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereBackupCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereBackupDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereBackupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereCompletionTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereIddataBackups($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataBackup whereStatus($value)
 */
	class DataBackup extends \Eloquent {}
}

namespace App\Models\SystemBackup{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorageUsage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorageUsage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorageUsage query()
 */
	class StorageUsage extends \Eloquent {}
}

namespace App\Models\SystemSettings{
/**
 * @property int $idadditional_work
 * @property string|null $description
 * @property float|null $rate
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdditionalWork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdditionalWork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdditionalWork query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdditionalWork whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdditionalWork whereIdadditionalWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdditionalWork whereRate($value)
 */
	class AdditionalWork extends \Eloquent {}
}

namespace App\Models\SystemSettings{
/**
 * @property int $idpartner_company
 * @property string|null $company_name
 * @property int|null $status Active/ Inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerCompany whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerCompany whereIdpartnerCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerCompany whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerCompany whereUpdatedAt($value)
 */
	class PartnerCompany extends \Eloquent {}
}

namespace App\Models\SystemSettings{
/**
 * @property int $idsolar
 * @property string|null $capacity
 * @property float|null $rate
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solar whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solar whereIdsolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solar whereRate($value)
 */
	class Solar extends \Eloquent {}
}

namespace App\Models\SystemSettings{
/**
 * @property int $idtechnician_level
 * @property float|null $basic_salary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianLevel whereBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianLevel whereIdtechnicianLevel($value)
 */
	class TechnicianLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models\UserManagement{
/**
 * @property int $idtechnician_registration
 * @property int $user_role_iduser_role
 * @property int $technician_level_idtechnician_level
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianRegistration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianRegistration whereIdtechnicianRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianRegistration whereTechnicianLevelIdtechnicianLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TechnicianRegistration whereUserRoleIduserRole($value)
 */
	class TechnicianRegistration extends \Eloquent {}
}

namespace App\Models\UserManagement{
/**
 * @property int $iduser
 * @property string $first_name
 * @property string|null $last_name
 * @property string $nic
 * @property string $contact_no
 * @property string $address
 * @property string $gender
 * @property string $dob
 * @property string $username
 * @property string $password
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $updated_at
 * @property int|null $user_registration_iduser_registration
 * @property int|null $technician_registration_idtechnician_registration
 * @property int|null $user_role_iduser_role
 * @property-read \App\Models\UserManagement\TechnicianRegistration|null $TechnicianRegistration
 * @property-read \App\Models\UserManagement\UserRegistration|null $UserRegistration
 * @property-read \App\Models\UserManagement\UserRole|null $UserRole
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectManagement\AssignTechnician> $assignedProjects
 * @property-read int|null $assigned_projects_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIduser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTechnicianRegistrationIdtechnicianRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserRegistrationIduserRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserRoleIduserRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models\UserManagement{
/**
 * @property int $iduser_registration
 * @property int $user_role_iduser_role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserManagement\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRegistration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRegistration whereIduserRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRegistration whereUserRoleIduserRole($value)
 */
	class UserRegistration extends \Eloquent {}
}

namespace App\Models\UserManagement{
/**
 * @property int $iduser_role
 * @property string|null $role_name
 * @property string|null $role_description
 * @property int|null $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereIduserRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereRoleDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereStatus($value)
 */
	class UserRole extends \Eloquent {}
}

