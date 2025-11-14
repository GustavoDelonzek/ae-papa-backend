<?php

namespace App\Enums;

enum EnumActionAuditLogs: string
{
    case USER_LOGIN = 'user_login';
    case USER_LOGOUT = 'user_logout';
    case USER_LOGIN_FAILED = 'user_login_failed';
    case USER_CREATED = 'user_created';
    case USER_UPDATED = 'user_updated';
    case USER_DELETED = 'user_deleted';
    case PATIENT_CREATED = 'patient_created';
    case PATIENT_UPDATED = 'patient_updated';
    case PATIENT_DELETED = 'patient_deleted';
    case CAREGIVER_CREATED = 'caregiver_created';
    case CAREGIVER_UPDATED = 'caregiver_updated';
    case CAREGIVER_DELETED = 'caregiver_deleted';
    case APPOINTMENT_CREATED = 'appointment_created';
    case APPOINTMENT_UPDATED = 'appointment_updated';
    case APPOINTMENT_DELETED = 'appointment_deleted';
    case DOCUMENT_UPLOADED = 'document_uploaded';
    case DOCUMENT_DOWNLOADED = 'document_downloaded';
    case DOCUMENT_DELETED = 'document_deleted';
}
